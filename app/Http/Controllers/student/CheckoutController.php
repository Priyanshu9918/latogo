<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use \Carbon\Carbon;
use Session;
use Mail;
class CheckoutController extends Controller
{
    public function index(Request $request)
    {   
        $item = \Cart::session(Auth::user()->id)->get('10');
        $item1 = \Cart::session(Auth::user()->id)->get('14');
        $item1 = \Cart::session(Auth::user()->id)->get('18');

        $data1 = \Cart::getContent()->count();
        
        $user_id = Auth::user()->id;
        $countries = DB::table('countries')->get();
        $billing  = DB::table('billing_details')->where('user_id',$user_id)->first();
        if(isset($billing->country)){
            $state  = DB::table('states')->where('country_id',$billing->country)->get();
        }else{
            $user = DB::table('student_details')->where('user_id',Auth::user()->id)->first();
            $state  = DB::table('states')->where('country_id',$user->country)->get();
        }
        if(isset($item) && $data1 == 1 || isset($item1) && $data1 == 1 || isset($item2) && $data1 == 1 ){
            if($billing != Null){
                return view('front.checkout.checkout1',compact('countries','state','billing'));
            }else{
                return view('front.checkout.checkout1',compact('countries','state'));
            }
        }else{
            if($billing != Null){
                return view('front.checkout.checkout',compact('countries','state','billing'));
            }else{
                return view('front.checkout.checkout',compact('countries','state'));
            }
        }
    }
    public function success(Request $request)
    {
            return view('front.success-payment');
    }
    public function cancle(Request $request)
    {
            return redirect()->back();
    }
    public function addToCartNew(Request $request)
    {
        if(Auth::check() && Auth::user()->user_type == '1'){
        $qty = 1;
        $price_master = DB::table('price_masters')->where('title','Private 1:1')->first();
        $Product = DB::table('pricings')->where('price_master',$price_master->id)->where('totle_class','1')->where('time','45')->where('status',1)->first();
        $rowId = 456; // generate a unique() row ID
        $user_id = Auth::user()->id; // the user ID to bind the cart contents
        // add the product to 
        // dd(Session::get('new_user111'));
            if(Session::has('new_user111') && Session::get('new_user111') == $Product->id){
                Session::forget('coupan');
                $countries = DB::table('countries')->get();
                $billing  = DB::table('billing_details')->where('user_id',$user_id)->first();
                if(isset($billing->country)){
                    $state  = DB::table('states')->where('country_id',$billing->country)->get();
                }else{
                    $user = DB::table('student_details')->where('user_id',Auth::user()->id)->first();
                    $state  = DB::table('states')->where('country_id',$user->country)->get();
                }
                if($billing != Null){
                    return view('front.checkout.checkout',compact('countries','state','billing'));
                }else{
                    return view('front.checkout.checkout',compact('countries','state'));
                }
            }else{
                \Cart::session($user_id)->add(array(
                    'id' => $Product->id,
                    'name' => $Product->totle_class,
                    'price' => $Product->total_price,
                    'quantity' => $qty,
                    'associatedModel' => $Product
                ));
                Session::put('new_user111',$Product->id);
                Session::put('ref_user',$Product->total_price);
                Session::forget('coupan');
                $countries = DB::table('countries')->get();
                $billing  = DB::table('billing_details')->where('user_id',$user_id)->first();
                if(isset($billing->country)){
                    $state  = DB::table('states')->where('country_id',$billing->country)->get();
                }else{
                    $user = DB::table('student_details')->where('user_id',Auth::user()->id)->first();
                    $state  = DB::table('states')->where('country_id',$user->country)->get();
                }
                if($billing != Null){
                    return view('front.checkout.checkout',compact('countries','state','billing'));
                }else{
                    return view('front.checkout.checkout',compact('countries','state'));
                }
            }
        }else{
            Session::put('new_user_id','data');
            return redirect()->route('front.login');
        }
    }
}
