<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Auth;
use Illuminate\Support\Facades\DB;
use \Carbon\Carbon;
use Session;
use Helper;

class CartController extends Controller
{
    public function cartList()
    {
        if(Auth::check() && Auth::user()->user_type == '1'){
            $userId = Auth::user()->id;
            $cartItems =\Cart::session($userId)->getContent();

            return view('front.cart.view-cart', compact('cartItems'));
        }else{
            return view('front.user.login');
        }

    }


    public function addToCart(Request $request)
    {
        if(Auth::check() && Auth::user()->user_type == '1'){
        $qty = 1;
        $productId = $request->id;
        $Product = DB::table('pricings')->where('id',$productId)->first(); // assuming you have a Product model with id, name, description & price
        $rowId = 456; // generate a unique() row ID
        $userID = Auth::user()->id; // the user ID to bind the cart contents
        // add the product to
        if(Session::get('currency') == 'EUR'){
            $total_price = Helper::currency($Product->total_price);
        }else{
            $total_price = $Product->total_price;
        } 
                \Cart::session($userID)->add(array(
                    'id' => $productId,
                    'name' => $Product->totle_class,
                    'price' => $total_price,
                    'quantity' => $qty,
                    'associatedModel' => $Product
                ));
            // return redirect()->route('student.cart.list');
            Session::forget('coupan');
            return response()->json([
                'success' =>true
            ]);
        }else{
            session::put('from_price',true);
            return response()->json([
                'success' =>false
            ]);
        }
    }

    public function updateCart(Request $request)
    {
        DB::beginTransaction();
        try{
        $userID = Auth::user()->id;
        $rowId = $request->id;
        $quantity = $request->quantity;
        if(is_array($quantity) && !empty($quantity)){
            $qty = [];
            for($i=0; $i < count($quantity); $i++){
                $id = $rowId[$i];
                 $data = $quantity[$i];
                    \Cart::session($userID)->update($request->id[$i], array(
                        'quantity' => array(
                            'relative' => false,
                            'value' => $quantity[$i]
                        ),
                    ));
            }   
            Session::put('cart', $qty);
            Session::forget('coupan');
        }
        return response()->json([
            'success' =>true
        ]);
        }
        catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return $e;
        }
        }

    public function removeCart(Request $request)
    {
        $userID = Auth::user()->id;
        $rowId = $request->id;
        if($rowId == 14){
            Session::forget('new_user111');
        }
        \Cart::session($userID)->remove($rowId);
        session()->flash('success', 'Item Cart Remove Successfully !');

        return redirect()->route('student.cart.list');
    }

    // public function clearAllCart()
    // {
    //     $userID = Auth::user()->id;
    //     \Cart::session($userID)->clear();

    //     session()->flash('success', 'All Item Cart Clear Successfully !');

    //     return redirect()->route('cart.list');
    // }
    public function coupan(Request $request)
    {
        $sub = \Cart::session(Auth::user()->id)->getSubTotal();
        $coupan_user = Auth::user()->id;
        $coupan = DB::table('records_of_references')->where('referral_coupon',$request->coupan_code)->where('referral_user_id',Auth::user()->id)->where('status',0)->get();
        $coupan_count = count($coupan);
        $coup_val = DB::table('referrals')->where('referral_coupon',$request->coupan_code)->first(); 
        if($coupan_count != 0){
            if($coup_val->referral < $sub){
                        $coupan_cd = $request->coupan_code;
                        $coupan1 = DB::table('referrals')->where('referral_coupon',$request->coupan_code)->first(); 
                        // $value = ($coupan->discount / 100) * $sub;
                        if(Session::get('currency') == 'EUR'){
                            $coupan_val = Helper::currency($coupan1->referral);
                        }else{
                            $coupan_val = $coupan1->referral;
                        }
                        $total = $sub - $coupan_val;
                        Session::put('coupan',[
                            'key' => $coupan_user,
                            'coupan_code' => $coupan_cd,
                            'discount' => $coupan_val,
                            'total' => $total
                        ]);
                        return response()->json(array('status'=>true,'coupan_val'=>$coupan_val,'total'=>$total,'coupan_cd'=>$coupan_cd));
            }
            else{
                $msg = 'Amount must be greater than Coupon value!';
                return response()->json(array('status'=>false,'msg'=>$msg));
            }
        }
        else{
                $msg = 'Invalid coupon code!';
                return response()->json(array('status'=>false,'msg'=>$msg));
        }
    }  

    public function remove(Request $request)
    {
        $msg = 'Coupon removed!';
        Session::forget('coupan');
        return response()->json(array('status'=>true,'msg'=>$msg));

    }

} 
