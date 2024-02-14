<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Validator;
use App\Models\BillingDetail;
use App\Models\Order;
use App\Models\CouponCode;
use App\Models\OrderItem;
use App\Models\Credit;
use App\Models\CreditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use \Carbon\Carbon;
use Session;
use Config;
use app\Helpers\HttpHelper1;
use app\Helpers\PayPalHelper1;
use Mail;

class PaymentController1 extends Controller
{
    public function paypalSubmit(Request $request)
    {
        // $coupan_id = $request->coupan_id;
        $user_id = Auth::user()->id;
        $user = $request->all();

        $rules = [
            'first_name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'last_name' => 'nullable|regex:/^[a-zA-Z ]+$/u|min:1|max:255',
            'phone' => 'required|numeric|regex:/^[0-9]+$/|min:5',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'postal_code' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validation->errors()
            ]);
        }
        return response()->json([
            'success' => true,
        ]);

    }
    public function paypalCourseOrderCreate(Request $request)
    {
        $user_id = Auth::user()->id;

        $name = trim(preg_replace('/^\s+|\s+$|\s+(?=\s)/', '', $request->input('first_name').' '.$request->input('last_name')));

            if($request->bill_id != null){
                $billing = [
                    'user_id' => $user_id,
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name'),
                    'name' => $name,
                    'address' => $request->input('address'),
                    'country' => $request->input('country'),
                    'state' => $request->input('state'),
                    'phone_no' => $request->input('phone'),
                    'remember' => $request->input('remember') ?? 0,
                    'postal_code' => $request->input('postal_code'),
                ];
                $bill_details = DB::table('billing_details')->where('id',$request->bill_id)->update($billing);
            }else{
                $bill_details = new BillingDetail;
                $bill_details->user_id = $user_id;
                $bill_details->first_name = $request->first_name;
                $bill_details->last_name = $request->last_name;
                $bill_details->name = $name;
                $bill_details->address = $request->address;
                $bill_details->country = $request->country;
                $bill_details->state = $request->state;
                $bill_details->phone_no = $request->phone;
                $bill_details->postal_code = $request->postal_code;
                $bill_details->remember = $request->remember ?? 0;
                $bill_details->save();
            }

            //order
            $order = new Order;
            $order->order_no = '#'.time();
            $order->user_id = $user_id;
            if($request->bill_id!=null){
                 $order->billing_id = $request->bill_id;
             }else{
                 $order->billing_id = $bill_details->id;
             }
            $order->sub_total = $request->sub_total;
            $order->discount = $request->discount;
            $order->payment_method = 'paypal';
            $order->total_price = $request->total_price;
            $order->billing_address = $request->address;
            $order->status = 1;
            $order->save();

            $order_no = $order->order_no;

            $quantity = $request->quantity;
            if(is_array($quantity) && !empty($quantity)){
                for($i=0; $i < count($quantity); $i++){
                    $order_item = new OrderItem;
                    $order_item->order_id = $order->id;
                    $order_item->class_id = $request->product_id[$i];
                    $order_item->base_price = $request->base_price[$i];
                    $order_item->price = $request->price[$i];
                    $order_item->quantity = $request->quantity[$i];
                    // DB::table('pricings')->where('id',$request->product_id[$i])->decrement('quantity', $request->quantity[$i]);
                    $order_item->save();
                }
            }
            $order_id = $order->id;

            $orderData = array(
                    "intent" => "CAPTURE",
                    "purchase_units" => array(
                        array(
                            "reference_id"=>$order_id,
                            "invoice_id"=>$order_id,
                            "custom_id"=>$order_id,
                            "amount"=> array(
                                "currency_code"=> Config::get('paypal.paypal_lib_currency_code'),
                                "value"=>$request->total_price
                            )
                        )
                    ),
                    "application_context"=> array(
                                            "return_url"=> "",
                                            "cancel_url"=> ""
                                        )
            );
            $paypalHelper = new PayPalHelper1;
            $res_order = $paypalHelper->orderCreate($orderData);

            Order::where('id',$order_id)->update([
                'paypal_order_id' => $res_order['data']['id']
            ]);

            header('Content-Type: application/json');
            echo json_encode($res_order);

            // $product_id = $request->product_id;
            // if(is_array($product_id) && !empty($product_id)){
            //     for($i=0; $i < count($product_id); $i++){
            //         \Cart::session($user_id)->remove($product_id[$i]);
            //     }
            // }

            }



    public function paypalOrderCapture(Request $request)
    {
        $paypalHelper = new PayPalHelper1;

        $res_order = $paypalHelper->orderCapture();

        // Check for Order Approved
        if(array_key_exists('status',$res_order['data']) && $res_order['data']['status']=='COMPLETED')
        {

            $query_update =  DB::table('orders')
                ->where('paypal_order_id', $res_order['data']['id'])
                ->update([
                'is_completed' => '1',
            ]);

            $cartItems =\Cart::session(Auth::user()->id)->getContent();
            foreach($cartItems as $item){
             $quantity = $item['quantity'];
             $product_id = $item['id'];
                     $cred = Credit::where('user_id',Auth::user()->id)->where('class_id',$product_id)->first();
                     $class1 = DB::table('pricings')->where('id',$product_id)->first();
                     CreditLog::insert(['user_id'=>Auth::user()->id,'class_id'=>$product_id,'credit'=>$quantity * $class1->totle_class , 'created_at'=> date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
                     if($cred == null){
                         $order_item = new Credit;
                         $order_item->user_id = Auth::user()->id;
                         $order_item->class_id = $product_id;
                         $order_item->credit = $quantity * $class1->totle_class;
                         $order_item->save();
                     }else{
                         $total_cred = ($quantity * $class1->totle_class) + $cred->credit;
                         $class1 = DB::table('credits')->where('user_id',Auth::user()->id)->where('class_id',$product_id)->update(['credit' => $total_cred]);
                     }
                     if($product_id == 14){
                        DB::table('referal_data_amount_new')->where('ref_rec_id',Auth::user()->id)->where('class_id',$product_id)->update(['status' => 1]);
                    }
             }

            $order = DB::table('orders')->where('paypal_order_id',$res_order['data']['id'])->where('is_completed',1)->first();
            $order_item = DB::table('order_items')->where('order_id',$order->id)->select('class_id')->get();
            $package_name1=[];
            foreach($order_item as $ordern){
                $classes = DB::table('pricings')->where('id',$ordern->class_id)->get();
                foreach($classes as $price){
                    $order_item = DB::table('price_masters')->where('id',$price->price_master)->first();
                    $package_name1 []= $order_item->title.' - '. $price->totle_class.'x Classes - '.'('.$price->time.' min)';
                }
            }
            $user_email = Auth::user()->email;
            $email =
                [
                'sender_email' => $user_email,
                'inext_email' => env('MAIL_USERNAME'),
                'sender_name' => Auth::user()->name,
                'created_at' => $order->created_at,
                'package_name' => $package_name1,
                'order_no' => $order->order_no,
                'title' => 'Successfully Registered!',
                ];

            Mail::send('email.student-order-confirmation', $email, function ($messages) use ($email) {
                $messages->to($email['sender_email'])
                ->from($email['inext_email'], 'Latogo');
                $messages->subject("Order Placed successfully!!");
            });

            $order_email = DB::table('orders')->where('user_id',Auth::user()->id)->where('is_completed',1)->get();
            $first_order = count($order_email);
            if($first_order == 1){
                $order_coupan = DB::table('records_of_references')->where('referring_user_id',Auth::user()->id)->first();
                $friend = DB::table('users')->where('id',$order_coupan->referral_user_id)->first();
                $email =
                [
                'sender_email' => $friend->email,
                'inext_email' => env('MAIL_USERNAME'),
                'friend_name' => Auth::user()->name,
                'sender_name' => $friend->name,
                'coupan_code' => $order_coupan->referral_coupon,
                'title' => 'Successfully Registered!',
                ];

                Mail::send('email.student-when-refer-a-friend', $email, function ($messages) use ($email) {
                $messages->to($email['sender_email'])
                ->from($email['inext_email'], 'Latogo');
                $messages->subject("Coupon Code Recieved!!");
            });
            }
            if(isset(Session::get('coupan')['discount'])){
                $coupan_code = Session::get('coupan')['discount'];
                $data = DB::table('records_of_references')->where('referral_user_id',Auth::user()->id)->where('status',0)->orderBy('id', 'desc')->first();
                DB::table('records_of_references')->where('id',$data->id)->update(['status' => 1]);
                Session::forget('coupan');
            }
            \Cart::session(Auth::user()->id)->clear();

        }
        header('Content-Type: application/json');
        echo json_encode($res_order);

    }

}
