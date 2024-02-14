<?php

namespace App\Http\Controllers\Auth\admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function login_view(){
        Auth::logout();
        return view('admin.login');
    }

    public function login(Request $request){

    $request->validate([
        'email' => 'required|email:rfc,dns|exists:users,email',
        'password' => 'required'
    ],
    [
        'email.exists' => 'This Email is Not Registered in Our System'
    ]
    );
    
    $is_email = User::where(['email'=>$request->email,'status'=>'0'])->latest()->first();
    $is_email1 = User::where(['email'=>$request->email,'status'=>'1'])->latest()->first();
    $is_deleted = User::where(['email'=>$request->email,'status'=>'2'])->latest()->first();
    if(!$is_email && !$is_email1){
        if($is_deleted!=NULL)
        {
            Session::flash('message', 'Your Account Has Been Deleted, Please Contact to System Administrator !!');
            Session::flash('alert-class', 'alert-danger');

            return redirect()->back();
        }
    }

    $deactive = User::where(['email'=>$request->email,'status'=>'0'])->latest()->first();

    if($deactive!=NULL)
    {
        Session::flash('message', 'Your Account Has Been Deactivated, Please Contact to System Administrator !!');
        Session::flash('alert-class', 'alert-danger');

        return redirect()->back();
    }

    $admin = User::where(['email'=>$request->email,'user_type'=>'0'])->latest()->first();
    if($admin){
        $check = $request->only('email','password');

        if(Auth::attempt($check))
        {
            return redirect()->route('admin.dashboard');
        }
        else
        {
            Session::flash('message', 'Credentials Not Matched!');
            Session::flash('alert-class', 'alert-danger');
    
            return redirect()->back();
        }
    }
    else{
        Session::flash('message', 'This account is not aur system Records!');
        Session::flash('alert-class', 'alert-danger');
        return redirect()->back();
    }

}
public function logout(Request $request)
{
    Auth::logout();

    return redirect('/admin/login');
}

}
