<?php

namespace App\Http\Controllers\Auth;

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
use Laravel\Socialite\Facades\Socialite;
use Exception;
use MikeMcLin\WpPassword\Facades\WpPassword;

class LoginController extends Controller
{
    public function login(Request $request){

        $request->validate([
            'email' => 'required|exists:users,email',
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
            Session::flash('message', 'Your account has been created & is under review. You will be notified once your account is approved.');
            Session::flash('alert-class', 'alert-danger');

            return redirect()->back();
        }
        $user = User::where(['email'=>$request->email])->whereIn('user_type',[1,2])->latest()->first();//,'user_type'=>'1'
        if($user){
            $check = $request->only('email','password');

            if(Auth::attempt($check))
            {
                if(Auth::user()->user_type == '1')
                {
                    if(Session::has('from_price') && Session::get('from_price')== true){
                        session()->forget('from_price');
                        return redirect()->route('view');
                    }
                    if(Session::has('support') && Session::get('support')== true){
                        session()->forget('support');
                        // return redirect('student/messages?user=1');
                        return redirect('/chatify/1');
                    }
                    if(Session::has('new_user_id') && Session::get('new_user_id') == 'data'){
                        session()->forget('new_user_id');
                        session()->forget('new_user111');
                        return redirect()->route('student.checkoutNew');
                    }
                    return redirect()->route('student.my-classes');
                }
                elseif(Auth::user()->user_type == '2')
                {
                    if(Session::has('support') && Session::get('support')== true){
                        session()->forget('support');
                        return redirect('teacher/messages?user=1');
                    }
                    return redirect()->route('teacher.dashboard');
                }
            }
            else
            {
                // $email_check = User::where(['email'=>$request->email])->latest()->first();
                // Check Wordpress Password Start
                if( WpPassword::check($request->password, $user->password) )
                {
                    Auth::login($user);
                    if(Auth::user()->user_type == '1')
                    {
                        if(Session::has('from_price') && Session::get('from_price')== true){
                            session()->forget('from_price');
                            return redirect()->route('view');
                        }
                        if(Session::has('support') && Session::get('support')== true){
                            session()->forget('support');
                            return redirect('student/messages?user=1');
                        }
                        if(Session::has('new_user_id') && Session::get('new_user_id') == 'data'){
                            session()->forget('new_user_id');
                            session()->forget('new_user111');
                            return redirect()->route('student.checkoutNew');
                        }
                        return redirect()->route('student.my-classes');
                    }
                    elseif(Auth::user()->user_type == '2')
                    {
                        if(Session::has('support') && Session::get('support')== true){
                            session()->forget('support');
                            return redirect('teacher/messages?user=1');
                        }
                        return redirect()->route('teacher.dashboard');
                    }
                }
                // Check Wordpress Password End

                Session::flash('message', "The password that you've entered is incorrect.");
                Session::flash('alert-class', 'alert-danger');

                return redirect()->back();
            }
        }
        else
        {
            Session::flash('message', 'Login Failed!');
            Session::flash('alert-class', 'alert-danger');

            return redirect()->back();
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('front.login');
    }

    public function login_view()
    {
        if(isset(Auth::user()->id)){
            return redirect('/');
        }else{
            if(request()->has('support'))
            {
                Session::put('support', true);
            }

            return view('front.login');
        }
    }

    //Gmail login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
      
            $user = Socialite::driver('google')->user();
            
            $finduser = User::where('google_id', $user->id)->first();
            $finduser1 = User::where('email',$user->email)->first();

            if($finduser){
       
                Auth::login($finduser);
      
                return redirect()->intended('/student/my-classes');
       
            } 
            elseif($finduser1){
                Session::flash('message', 'Email used by another user!');
                Session::flash('alert-class', 'alert-danger');
        
                return redirect()->intended('/user/login');
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'user_type' =>1,
                    'password' => encrypt('123456dummy')
                ]);

                $data1 = [
                    'user_id' => $newUser->id,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $user_id1 = DB::table('student_details')->insert($data1);
      
                Auth::login($newUser);
      
                return redirect()->intended('/student/my-classes');
            }
      
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    //facebook login
    public function redirectFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookCallback()
    {
        try {
        
            $user = Socialite::driver('facebook')->user();
         
            $finduser = User::where('facebook_id', $user->id)->first();
            $finduser1 = User::where('email',$user->email)->first();

            if($finduser){
         
                Auth::login($finduser);
        
                return redirect()->intended('/student/my-classes');
         
            }elseif($finduser1){

                Session::flash('message', 'Email used by another user!');
                Session::flash('alert-class', 'alert-danger');
        
                return redirect()->intended('/user/login');

            }else{

                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'facebook_id'=> $user->id,
                    'user_type' =>1,
                    'password' => encrypt('Test123456')
                ]);

                $data1 = [
                    'user_id' => $newUser->id,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $user_id1 = DB::table('student_details')->insert($data1);
        
                Auth::login($newUser);
        
                return redirect()->intended('/student/my-classes');

            }
        
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
