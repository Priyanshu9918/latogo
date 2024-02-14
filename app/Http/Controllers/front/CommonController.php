<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Helpers\Helper;
use Illuminate\Support\str;
use Carbon\Carbon;
use App\Models\User;
use Mail;
use Illuminate\Http\Response;

class CommonController extends Controller
{
    //
    public function supportView(Request $request)
    {
         $support = DB::table('contact_queries')->where('contact_id',1)->where('status',1)->get();

        return view('front/support')->with(['support' => $support]);
    }
    public function support(Request $request)
    {
         $support = DB::table('contact_queries')->where('contact_id',$request->active)->where('status',1)->get();

        return view('front/support_t')->with(['support' => $support]);
    }

    public function checkMsg(Request $request)
    {
        return Helper::msgCount();
    }

    public function userImport(Request $request)
    {
        ini_set('max_execution_time', '0');

        $data_set = array();
        $file = fopen(public_path('user_export.csv'),"r");
        echo '<pre>';
        $i = 0;
        while(! feof($file))
        {   
            if($i==0){ $i++;  continue; }

            $row = fgetcsv($file);
            if(isset($row[5]))
            {
                $data['name'] = $row[9]??'' .' '.  $row[9]??'';
                $data['email'] = $row[5];
                $data['password'] = $row[3];
                $data['user_type'] = 1;
                $data['status'] = 1;
                $data['reffer_code'] = str::random(10);
                $data['created_at'] = Carbon::now();
                $data['updated_at'] = Carbon::now();
                

                $data_set[] = $data;
            }
            
                
        }
        // User::insert($data_set);
        print_r($data_set);


        fclose($file);
    }

    public function userImgChange(Request $request)
    {
        ini_set('max_execution_time', '0');
        // $students = User::select('email','name')->where('user_type',1)->get();

        // foreach($students as $std)
        // {
        //     if(filter_var($std->email, FILTER_VALIDATE_EMAIL)) {
        //         $email =
        //         [
        //         'sender_email' => str_replace(' ','',$std->email),
        //         'inext_email' => env('MAIL_USERNAME'),
        //         'name' => $std->name,
        //         'title' => 'Successfully Registered!',
        //         ];

        //         Mail::send('email.new-website-launch-at-latogo', $email, function ($messages) use ($email) {
        //             $messages->to($email['sender_email'])
        //             ->from($email['inext_email'], 'Latogo');
        //             $messages->subject("New Website Launch at Latogo.de!");
        //         });

        //     }
                
        // }

        $users      = User::select('*')->whereNotNull('mh_user_id')->get();
        $merithub   = DB::table('merithub_creditionals')->first();

        foreach($users as $user)
        {
            $mh_user_id = $user->mh_user_id;

            if($user->user_type==1)
            {   
                $student    = DB::table('student_details')->where('user_id',$user->id)->first();
                $imgage     = ($student!=null && $student->avtar!=null)? url('uploads/user/avatar/').'/'.$student->avtar:'https://classes.latogo.de/assets/img/fav.png';
                $st         = ($student!=null && $student->timezone!=null)?$student->timezone:'136';
                $timezone   = DB::table('time_zones')->where('id',$st)->first();
            }
            elseif($user->user_type==2)
            {
                $tutor      = DB::table('teacher_settings')->where('user_id',$user->id)->first();
                $imgage     = ($tutor!=null && $tutor->avatar!=null)? url('uploads/user/avatar/').'/'.$tutor->avatar:'https://classes.latogo.de/assets/img/fav.png';
                $tt         = ($tutor!=null && $tutor->timezone!=null)?$tutor->timezone:'136';
                $timezone   = DB::table('time_zones')->where('id',$tt)->first();
            }
            else{
                continue;
            }
            
            $headers   = array("content-type: application/json", "Authorization:".$merithub->merithub_token);

            $this->meritHubUserUpdate($merithub->client_id, $mh_user_id, $imgage, $timezone->timezone, $user, $headers);

        }

        echo '<h3>Process Done</h3>';
            
    }

    public function meritHubUserUpdate($c_id, $mu_id, $u_img, $tz, $u_data, $headers){

        // echo $mu_id;
        $url    = "https://serviceaccount1.meritgraph.com/v1/".$c_id."/users/".$mu_id;
        $data   = array("name"=>$u_data->name,
                        "img"=> $u_img,
                        "lang"=>"en",
                        "clientUserId"=>"LATOGO-".$u_data->id,
                        "email"=>$u_data->email,
                        "role"=>"M",
                        "timeZoneId"=>$tz,
                        "permission"=>"CJ"
                    );

        $post_data  = json_encode($data);

        $curl       = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($curl);
        curl_close($curl);
        
        // dd($result);
        return true;
    }

    public function CurrencyChanges(Request $request)
    {
        // Session::forget('currency');
        if(Auth::check()){
            \Cart::session(Auth::user()->id)->clear();
        }
        Session::put('currency', $request->currency);
        // return $request->all();

        return response()->json([
            'success' => true
        ]);

    }
    public function verification(Request $request)
    {
         $dateOfBirth = $request->date;

            if($dateOfBirth >= 19){
                $response = new Response('Cookie set on click');
                $response->cookie('example_cookie', 'example_value', 24 * 60);
                Session::put('years', 'current',60);
                Session::put('msg', 'set cookie successfully',60);
                return response()->json(array('status'=>true,'message'=>'Your cookie has been set successfully!'));
            }else{
                Session::put('years', 'current',60);
                Session::put('msg', 'cookie refused',60);
                return response()->json(array('status'=>false,'message'=>'Your cookie is not set successfully!'));   
            }
    }

}
