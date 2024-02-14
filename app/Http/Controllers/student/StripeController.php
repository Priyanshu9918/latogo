<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stripe\Exception\CardException;
use Stripe\StripeClient;
use App\Models\BillingDetail;
use App\Models\Credit;
use App\Models\CreditLog;
use App\Models\Order;
use App\Models\CouponCode;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Mail;
use Session;
use Stripe\PaymentMethod;

class StripeController extends Controller
{
    private $stripe;
    // public function __construct()
    // {
    //     $this->stripe = new StripeClient(config('stripe.api_keys.secret_key'));
    // }
    public function __construct()
    {
        $stripeSecretKey = config('stripe.api_keys.secret_key');
        // dd($stripeSecretKey);
        $this->stripe = new StripeClient($stripeSecretKey);
    }

    public function payment(Request $request)
    {
        $rules = [
            'fullName' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'cardNumber' => 'required|min:1|max:16|regex:/[0-9]{5}/',
            'month' => 'required',
            'year' => 'required',
            'cvv' => 'required|min:3|max:3'
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validation->errors()
            ]);
        }

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
                    'postal_code' => $request->input('postal_code'),
                    'remember' => $request->input('remember') ?? 0,
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
            $order->order_no = 'latogo'.time();
            $order->user_id = $user_id;
            if($request->bill_id!=null){
                 $order->billing_id = $request->bill_id;
             }else{
                 $order->billing_id = $bill_details->id;
             }
            $order->sub_total = $request->sub_total;
            $order->discount = $request->discount;
            $order->payment_method = 'Stripe';
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

        $token = $this->createToken($request);
        if (!empty($token['error'])) {
            $request->session()->flash('danger', $token['error']);
            return response()->json([
                'success' => false,
                'errors' => 'Invalid Card Details!'
            ]);
        }
        if (empty($token['id'])) {
            return response()->json([
                'success' => false,
                'errors' => 'payment failed'
            ]);
        }

        $price = $request->total_price * 100;

        $plan = $this->createPlan($price, $order_id);
        // dd($plan);
        if (!empty($plan) && $plan['active'] == true) {
            $charge = $this->createSubscription(Auth::user(), $token['id'], $plan['id']);
            // dd($charge);
            if (!empty($charge) && $charge['status'] == 'active') {

                $order_item = DB::table('order_items')->where('order_id',$order_id)->select('class_id')->get();
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

                $query_update =  DB::table('orders')
                    ->where('id', $order_id)
                    ->update([
                    'stripe_order_id' => $charge['id'],
                    'is_completed' => '1'
                ]);

                $quantity = $request->quantity;
                if(is_array($quantity) && !empty($quantity)){
                    for($i=0; $i < count($quantity); $i++){
                        $cred = Credit::where('user_id',$user_id)->where('class_id',$request->product_id[$i])->first();
                        $class0 = DB::table('pricings')->where('id',$request->product_id[$i])->first();
                        CreditLog::insert(['user_id'=>$user_id,'class_id'=>$request->product_id[$i],'credit'=>$request->quantity[$i] * $class0->totle_class]);
                        if($cred == null){
                            $class1 = DB::table('pricings')->where('id',$request->product_id[$i])->first();
                            $order_item = new Credit;
                            $order_item->user_id = $user_id;
                            $order_item->class_id = $request->product_id[$i];
                            $order_item->credit = $request->quantity[$i] * $class1->totle_class;
                            // DB::table('pricings')->where('id',$request->product_id[$i])->decrement('quantity', $request->quantity[$i]);
                            $order_item->save();

                            // $now = date('Y-m-d H:i:s');
                            $t_timezone = DB::table('users')->where('id',$user_id)->first();
                            $t_timezones = DB::table('student_details')->where('user_id',$t_timezone->id)->first();
                            $timezone = DB::table('time_zones')->where('id',$t_timezones->timezone)->first();
                            $tz = $timezone->timezone ?? 'Asia/Kolkata';

                            $current_time  = new \DateTime(date('Y-m-d H:i:s'), new \DateTimeZone($tz));
                            $current_time->setTimezone(new \DateTimeZone('UTC'));
                            $current_time1 = $current_time;

                            $oneMonthLater = $current_time->modify('+1 month');

                            $order111ss = DB::table('orders')->where('id',$order_id)->first();

                            $data = [
                                'order_id' => $order_id,
                                'subscription_id' => $order111ss->stripe_order_id,
                                'user_id' => $user_id,
                                'class_id' => $request->product_id[$i],
                                'credit' => $request->quantity[$i] * $class1->totle_class,
                                'status' => 1,
                                'purchase_at' => date('Y-m-d H:i:s'),
                                'next_payment' => $oneMonthLater,
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s')
                            ];
                
                            DB::table('subscription_credit')->insert($data);

                        }else{
                            $class1 = DB::table('pricings')->where('id',$request->product_id[$i])->first();
                            $cred_value = DB::table('credits')->where('user_id',$user_id)->where('class_id',$request->product_id[$i])->first();
                            $total_cred = ($request->quantity[$i] * $class1->totle_class) + $cred_value->credit;
                            $credit = [
                                'credit' => $total_cred,
                            ];
                            DB::table('credits')->where('user_id',$user_id)->where('class_id',$request->product_id[$i])->update($credit);

                            $t_timezone = DB::table('users')->where('id',$user_id)->first();
                            $t_timezones = DB::table('student_details')->where('user_id',$t_timezone->id)->first();
                            $timezone = DB::table('time_zones')->where('id',$t_timezones->timezone)->first();
                            $tz = $timezone->timezone ?? 'Asia/Kolkata';

                            $current_time  = new \DateTime(date('Y-m-d H:i:s'), new \DateTimeZone($tz));
                            $current_time->setTimezone(new \DateTimeZone('UTC'));
                            $current_time1 = $current_time;

                            $oneMonthLater = $current_time->modify('+1 month');

                            $order111ss = DB::table('orders')->where('id',$order_id)->first();

                            $data = [
                                'order_id' => $order_id,
                                'subscription_id' => $order111ss->stripe_order_id,
                                'user_id' => $user_id,
                                'class_id' => $request->product_id[$i],
                                'credit' => $request->quantity[$i] * $class1->totle_class,
                                'status' => 1,
                                'purchase_at' => date('Y-m-d H:i:s'),
                                'next_payment' => $oneMonthLater,
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s')
                            ];
                
                            DB::table('subscription_credit')->insert($data);
                        }
                        if($request->product_id[$i] == 14){
                            DB::table('referal_data_amount_new')->where('ref_rec_id',Auth::user()->id)->where('class_id',$request->product_id[$i])->update(['status' => 1]);
                        }

                    }
                }

                $order_email = DB::table('orders')->where('user_id',Auth::user()->id)->where('is_completed',1)->get();
                $first_order = count($order_email);
                    if($first_order == 1){
                        $order_coupan = DB::table('records_of_references')->where('referring_user_id',Auth::user()->id)->first();

                        if($order_coupan!=null)
                        {
                            $friend = DB::table('users')->where('id',$order_coupan->referral_user_id)->first();
                            $fn = $friend->name;

                            $email =
                            [
                            'sender_email' => $friend->email,
                            'inext_email' => env('MAIL_USERNAME'),
                            'friend_name' => Auth::user()->name,
                            'sender_name' => $fn,
                            'coupan_code' => $order_coupan->referral_coupon,
                            'title' => 'Successfully Registered!',
                            ];

                            Mail::send('email.student-when-refer-a-friend', $email, function ($messages) use ($email) {
                                $messages->to($email['sender_email'])
                                ->from($email['inext_email'], 'Latogo');
                                $messages->subject("Coupon Code Recieved!!");
                            });
                        }


                }

                if(isset(Session::get('coupan')['discount'])){
                    $coupan_code = Session::get('coupan')['discount'];
                    $data = DB::table('records_of_references')->where('referral_user_id',Auth::user()->id)->where('status',0)->orderBy('id', 'desc')->first();
                    DB::table('records_of_references')->where('id',$data->id)->update(['status' => 1]);
                    Session::forget('coupan');
                }

                \Cart::session($user_id)->clear();

                return response()->json([
                    'success' => true,
                ]);
            } else {
                return response()->json([
                    'success' => 1,
                    'errors' => 'payment failed2'
                ]);
            }
        }else{
            return response()->json([
                'success' => 1,
                'errors' => 'payment failed2'
            ]); 
        }
            return response()->json([
                'success' => true,
            ]);
    }

    private function createToken($cardData)
    {
        $token = null;
        try {
            $token = $this->stripe->tokens->create([
                'card' => [
                    'number' => $cardData['cardNumber'],
                    'exp_month' => $cardData['month'],
                    'exp_year' => $cardData['year'],
                    'cvc' => $cardData['cvv']
                ]
            ]);
        } catch (CardException $e) {
            $token['error'] = $e->getError()->message;
        } catch (Exception $e) {
            $token['error'] = $e->getMessage();
        }
        return $token;
    }

    private function createPlan($amount, $order)
    {

        $charge = null;
        try {
            $product = $this->stripe->products->create([
                'name' => 'latogo_class',
            ]);

            $productId = $product->id;

            $charge = $this->stripe->plans->create([
                'amount' => $amount,
                'currency' => 'usd',
                'interval' => 'month',
                'product' => $productId,
              ]);

        } catch (Exception $e) {
            $charge['error'] = $e->getMessage();
        }
        return $charge;
    }

    private function createSubscription($user, $tokenId, $planId)
    {
        try {
            // Retrieve the customer's Stripe ID
            $customer = $this->getStripeCustomerId($user);
            // dd($customer);
            \Stripe\Stripe::setApiKey(config('stripe.api_keys.secret_key'));
            // Convert token to PaymentMethod
            $paymentMethod = PaymentMethod::create([
                'type' => 'card',
                'card' => [
                    'token' => $tokenId,
                ],
            ]);

            // PaymentMethod::attach($paymentMethod->id,['customer'=>Auth::user()->id]);
            $this->stripe->paymentMethods->attach($paymentMethod->id,['customer'=>$customer]);
            // dd($paymentMethod);
            // Create a subscription
            $subscription = $this->stripe->subscriptions->create([
                'customer' => $customer,
                'items' => [
                    ['price' => $planId],
                ],
                'default_payment_method' => $paymentMethod->id,
            ]);
    
            return $subscription;
        } catch (Exception $e) {
            // dd($e->getMessage());
            return [
                'error' => $e->getMessage(),
            ];
        }
    }
    private function getStripeCustomerId($user)
    {
        $stripeCustomerId = $user->stripe_customer_id;
        // dd($stripeCustomerId);

        if (!$stripeCustomerId) {
            // If the Stripe Customer ID is not stored in the database, create a new customer on Stripe
            $customer = $this->stripe->customers->create([
                'email' => $user->email,
            ]);

            // Save the Stripe Customer ID in the database
            $user->stripe_customer_id = $customer->id;
            $user->save();

            $stripeCustomerId = $customer->id;
        }

        return $stripeCustomerId;
    }

    public function cancle(Request $request)
    {
        $stripeCustomerId = base64_decode($request->id);
        // dd($stripeCustomerId);

        if ($stripeCustomerId) {
            $customer = $this->stripe->subscriptions->update($stripeCustomerId, ['cancel_at_period_end' => true]);
            $credit = [
                'status' => 0,
            ];
            DB::table('subscription_credit')->where('user_id',Auth::user()->id)->where('subscription_id',$stripeCustomerId)->update($credit);

        }
        

        return redirect()->back();
    }
    public function active(Request $request)
    {
        $stripeCustomerId = base64_decode($request->id);
        // dd($stripeCustomerId);

        if ($stripeCustomerId) {
            $customer = $this->stripe->subscriptions->update($stripeCustomerId, ['cancel_at_period_end' => false]);
            $credit = [
                'status' => 1,
            ];
            DB::table('subscription_credit')->where('user_id',Auth::user()->id)->where('subscription_id',$stripeCustomerId)->update($credit);
        }
        

        return redirect()->back();
    }
}
