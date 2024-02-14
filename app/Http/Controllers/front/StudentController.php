<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Records_of_references;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\str;
use App\Models\Bookclass;
use App\Models\Pricing;
use App\Models\Availability;
use App\Models\Message;
use App\Models\Order;
use App\Models\Credit;
use Auth;
use Mail;
use Session;
use App\Lib\PusherFactory;
use Carbon\Carbon;
use App\Models\BookSession;
use App\Models\TeacherSetting;
use App\Models\StudentDetail;
use App\Models\TimeZone;
use Event;
use App\Events\SendMail;
use App\Models\CreditLog;
use File;
use App\Models\Unavailability;


class StudentController extends Controller
{
    public function index()
    {
        $tz     = Auth::user()->load('StudentDetail.TimeZone');
        $tz     = ($tz->StudentDetail != null && $tz->StudentDetail->TimeZone!=null)?$tz->StudentDetail->TimeZone->timezone:'Europe/Berlin';
        $i      = 0;
        $date   = new \DateTime();
        // $date->setTimezone(new \DateTimeZone($tz));
        $date->setTimezone(new \DateTimeZone('UTC'));
        $cur_date = $date->format('Y-m-d H:i:s');
        $data0    = array();
        $data1    = array();
        $data2    = array();

        $upcommit = BookSession::where('student_id',auth()->user()->id)
        // ->whereDate('end_time', '>', $cur_date)
        ->where('end_time', '>=', $cur_date)
        ->where('student_url','<>',null)
        // ->orderBy('id','DESC')
        ->orderBy('start_time','ASC')
        ->get();

        // dd($upcommit);

        $upcommit1 = BookSession::where('student_id',auth()->user()->id)
                    // ->whereDate('end_time', '>', $cur_date)
                    ->where('end_time', '>=', $cur_date)
                    // ->orderBy('id','DESC')
                    ->where('is_cancelled',0)
                    ->orderBy('start_time','ASC')
                    ->get();
        
        // $past =     BookSession::where('student_id',auth()->user()->id)
        //             ->whereDate('end_time', '<', $cur_date)
        //             ->orderBy('id','DESC')
        //             ->get();

        $date_set = [$date->format('Y-m-d')];
        while($i<5)
        {
            $date->modify('-1 month');
            $date_set[] = $date->format('Y-m-d');
            $data0[] = $date->format('M Y');
            $i++;
        }

        foreach($date_set as $ds)
        {
            $data1[] = Order::where(['user_id'=>Auth::user()->id,'is_completed'=>1])
                            ->whereYear('created_at', date('Y',strtotime($ds)))
                            ->whereMonth('created_at', date('m',strtotime($ds)))
                            ->count();

            $data2[] = CreditLog::where(['user_id'=>Auth::user()->id])
                            ->whereYear('created_at', date('Y',strtotime($ds)))
                            ->whereMonth('created_at', date('m',strtotime($ds)))
                            ->sum('credit');

        }

        // dd($data2);
        return view('front.student-dashboard',compact('upcommit','upcommit1','tz','data0','data1','data2'));
    }

    public function register(Request $request)
    {

        if(isset(Auth::user()->id))
        {
            return redirect('student/dashboard');
        }
        else
        {
            if ($request->isMethod('get'))
            {
                $reffer_code = $request->get('reffer_code');
                return view('front.register',compact('reffer_code'));
            }

            $rules = [
                'name' => 'required|min:1|max:255|regex:/^[a-zA-Z\s]*$/',
                'email' => ['required',Rule::unique('users')->where(fn ($query) => $query->where('status','<>', 2))],
                'phone' => 'required|regex:/^[0-9]+$/|min:5',
                'password' => 'required|min:5',
                'term' => 'required'
            ];

            $reffer_code = str::random(10);

            $custom = [
                'email.unique'  => 'Email id has already been taken',
                'phone.regex' => 'Phone Number Must be Numeric',

            ];

            $validation = Validator::make($request->all(), $rules, $custom);

            if ($validation->fails()) {

                return response()->json([
                    'success' => false,
                    'errors' => $validation->errors()
                ]);
            }
            DB::beginTransaction();
            try {

            $hashed_random_password = Hash::make($request->input('password'));

            $data = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'reffer_code' => $reffer_code,
                'phone' => $request->input('phone'),
                'password' => $hashed_random_password,
                'user_type' => 1,
                'status' => 1,
                'term' => $request->input('term'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            $user_id = DB::table('users')->insertGetId($data);
                $data1 = [
                    'user_id' => $user_id,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $user_id1 = DB::table('student_details')->insert($data1);
                if($request->has('reffer_codes') && $request->get('reffer_codes')!=null)
                {
                    $refferal = DB::table('referrals')->latest()->first();
                    $userData = DB::table('users')->where('reffer_code', $request->get('reffer_codes'))->first();
                    if($userData!=null)
                    {
                        DB::table('records_of_references')->insert([
                            'referral_user_id' => $userData->id,
                            'referring_user_id' => $user_id,
                            'referral_amount' => $refferal->referral,
                            'referral_coupon' => $refferal->referral_coupon,
                            'referring_amount' =>$refferal->referring,
                            'referring_coupon' =>$refferal->referring_coupon,
                            'created_at' => date('Y-m-d H:i:s')
                        ]);
                        DB::table('referal_data_amount_new')->insert([
                            'ref_send_id' => $userData->id,
                            'ref_rec_id' => $user_id,
                            'class_id' => 14,
                            'amount' => 35,
                            'status' => 0,
                            'created_at' => date('Y-m-d H:i:s')

                        ]);
                    $data = [
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'phone' => $request->input('phone'),
                        'password' => $hashed_random_password,
                        'plan_password' => $request->input('password'),
                        'user_type' =>1,
                        'status' => 1,
                        'term' => $request->input('term'),
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                }
                session()->forget('new_user111');
                $email1 =
                [
                'sender_email' => $request->email,
                'inext_email' => env('MAIL_USERNAME'),
                'sender_name' => $request->name,
                'title' => 'Successfully Registered!',
                ];

                Mail::send('email.student-after-referal', $email1, function ($messages) use ($email1) {
                    $messages->to($email1['sender_email'])
                    ->from($email1['inext_email'], 'Latogo');
                    $messages->subject("Welcome to Latogo - Your $5 German Class Awaits!");
                });
            }else{
                $email =
                [
                'sender_email' => $request->email,
                'inext_email' => env('MAIL_USERNAME'),
                'sender_name' => $request->name,
                'title' => 'Successfully Registered!',
                ];

                Mail::send('email.student-email-content-and-subject-after-successfully-registration', $email, function ($messages) use ($email) {
                    $messages->to($email['sender_email'])
                    ->from($email['inext_email'], 'Latogo');
                    $messages->subject("Welcome to Latogo - Let's Begin Your German Language Journey!");
                });
            }
                session::put('timezone','set timezone');

                $user = User::where(['email'=>$request->email])->where('user_type',1)->latest()->first();//,'user_type'=>'1'

                if($user){
                    $check = $request->only('email','password');

                    if(Auth::attempt($check))
                    {
                        if(Auth::user()->user_type == '1')
                        {
                            DB::commit();
                            return response()->json([
                                'success' =>true
                            ]);
                        }
                    }
                }

                DB::commit();
                return response()->json([
                    'success' => true
                ]);
            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return $e;
            }
        }
    }

    public function class_details(Request $request)
    {
        $tz     = Auth::user()->load('StudentDetail.TimeZone');
        $tz     = ($tz->StudentDetail != null && $tz->StudentDetail->TimeZone!=null)?$tz->StudentDetail->TimeZone->timezone:'Europe/Berlin';

        date_default_timezone_set($tz);

        $class = DB::table('bookclasses')->where('id',$request->id)->first();
        $user  = auth()->user()->load('Credit.Classis.MasterClass');

        return view('front.student-book-a-class-detail', compact('class', 'user'));
    }
    public function messages(Request $request)
    {
        DB::table('messages')->where(['to_user'=>Auth::user()->id])->update(['is_read'=>1]);
        // dd('re');
        $ids = array();
        $messages = Message::select('from_user','to_user')
                                    ->where(function ($query) use ($request) {
                                        $query->where('from_user', Auth::user()->id);
                                    })->orWhere(function ($query) use ($request) {
                                        $query->where('to_user', Auth::user()->id);
                                    })
                                    // ->groupBy('to_user','from_user')
                                    ->orderBy('created_at', 'ASC')
                                    ->get();
        foreach($messages as $msg)
        {
            if($msg->to_user!=Auth::user()->id)
            {
                $ids[] = $msg->to_user;
            }
            if($msg->from_user!=Auth::user()->id)
            {
                $ids[] = $msg->from_user;
            }

        }

        if(request()->has('user') && request()->get('user')!='')
        {
            $ids[] = request()->get('user');
        }
        $users = User::whereIn('id',$ids)->where('id', '!=', Auth::user()->id)->get();
        return view('front.message', compact('users'));
    }

    public function getLoadLatestMessages(Request $request)
    {
        if (!$request->user_id) {
            return;
        }
        $messages = Message::where(function ($query) use ($request) {
            $query->where('from_user', Auth::user()->id)->where('to_user', $request->user_id);
        })->orWhere(function ($query) use ($request) {
            $query->where('from_user', $request->user_id)->where('to_user', Auth::user()->id);
        })->orderBy('created_at', 'ASC')->get(); //->limit(10)
        $return = [];
        foreach ($messages as $message) {
            $return[] = view('front.message-line')->with('message', $message)->render();
        }

        //Find Avatar
        $user = User::where('id',$request->user_id)->first();
        $img  = asset('assets/img/user/user.png');
        if($user!=null && $user->user_type=='1')
        {
            $detail = StudentDetail::where('user_id',$user->id)->first(); //
            if($detail!=null and $detail->avtar!=null)
            {
                $img  = (File::exists(public_path('uploads/user/avatar/'.$detail->avtar)))?asset('uploads/user/avatar/'.$detail->avtar):asset('assets/img/user/user.png');
            }
        }
        if($user!=null && $user->user_type=='2')
        {
            $detail = TeacherSetting::where('user_id',$user->id)->first(); //TeacherSetting
            if($detail!=null and $detail->avatar!=null)
            {
                $img  = (File::exists(public_path('uploads/user/avatar/'.$detail->avatar)))?asset('uploads/user/avatar/'.$detail->avatar):asset('assets/img/user/user.png');
            }
        }
        
        return response()->json(['state' => 1,'img'=>$img, 'messages' => $return]);
    }
    public function postSendMessage(Request $request)
    {
        if (!$request->to_user || !$request->message) {
            return;
        }
        $data = DB::table('messages')->where('from_user',Auth::user()->id)->where('to_user',$request->to_user)->whereDate('created_at', \Carbon\Carbon::today())->latest()->first();
        if($data == null){
            event(new SendMail($request->to_user));
        }

        $message = new Message();
        $message->from_user = Auth::user()->id;
        $message->to_user = $request->to_user;
        $message->content = $request->message;
        $message->save();
        // prepare some data to send with the response
        $message->dateTimeStr = date("Y-m-dTH:i", strtotime($message->created_at->toDateTimeString()));
        $message->dateHumanReadable = $message->created_at->diffForHumans();
        $message->fromUserName = $message->fromUser->name;
        $message->from_user_id = Auth::user()->id;
        $message->toUserName = $message->toUser->name;
        $message->to_user_id = $request->to_user;
        PusherFactory::make()->trigger('chat', 'send', ['data' => $message]);
        return response()->json(['state' => 1, 'data' => $message]);
    }

    public function getOldMessages(Request $request)
    {
        if (!$request->old_message_id || !$request->to_user)
            return;
        $message = Message::find($request->old_message_id);
        $lastMessages = Message::where(function ($query) use ($request, $message) {
            $query->where('from_user', Auth::user()->id)
                ->where('to_user', $request->to_user)
                ->where('created_at', '<', $message->created_at);
        })
            ->orWhere(function ($query) use ($request, $message) {
                $query->where('from_user', $request->to_user)
                    ->where('to_user', Auth::user()->id)
                    ->where('created_at', '<', $message->created_at);
            })
            ->orderBy('created_at', 'ASC')->limit(10)->get();
        $return = [];
        if ($lastMessages->count() > 0) {
            foreach ($lastMessages as $message) {
                $return[] = view('front.message-line')->with('message', $message)->render();
            }
            PusherFactory::make()->trigger('chat', 'oldMsgs', ['to_user' => $request->to_user, 'data' => $return]);
        }
        return response()->json(['state' => 1, 'data' => $return]);
    }

    public function cal_data_old(Request $request)
    {
        // date_default_timezone_set("Europe/Paris");
        $tz_f   = Auth::user()->load('StudentDetail.TimeZone');
        $tz     = ($tz_f->StudentDetail != null && $tz_f->StudentDetail->TimeZone!=null)?$tz_f->StudentDetail->TimeZone->timezone:'Europe/Berlin';
        $tz1    = ($tz_f->StudentDetail != null && $tz_f->StudentDetail->TimeZone!=null)?$tz_f->StudentDetail->TimeZone->raw_offset:'1.00';
        date_default_timezone_set($tz);

        $class_id   = $request->c_id;
        $teacher_id = $request->t_id;
        $c_detail   = Pricing::where('id',$class_id)->first();
        $teacher_av = Availability::where('user_id',$teacher_id)->get();
        $interval   = ($c_detail!=null && $c_detail->time!=null)?$c_detail->time:'00';
        $interval   = (int)$interval;
        $day        = array();
        $events     = array();
        // dd($teacher_av);
        foreach($teacher_av as $t_av)
        {

            $find_to = strtotime(date('Y-m-d').' '.$t_av->time_from);
            $find_to = date('h:i A',strtotime('+'.$interval.' minutes',$find_to));
            // if (substr($find_to, 0, 1) === '0') {
            //     $find_to = substr($find_to, 1);
            // }
            // echo $t_av->time_to.'=='.$find_to.'<br>';
            if($t_av->time_to==$find_to)
            {
                $time_from  = date('Y-m-d').''.$t_av->time_from;
                $time_to    = date('Y-m-d').''.$t_av->time_to;

                $teacherD   = TeacherSetting::where('user_id',$teacher_id)->first();
                $tz0        = TimeZone::where('id',$teacherD->timezone ?? 136)->first();
                $tz0        = $tz0->timezone;

                $time_from_t1   = new \DateTime($time_from, new \DateTimeZone('UTC'));
                $time_to_t1     = new \DateTime($time_to, new \DateTimeZone('UTC'));

                // $time_from_t1   = new \DateTime($time_from_t1->format("h:i A"), new \DateTimeZone($tz0));
                // $time_to_t1     = new \DateTime($time_to_t1->format("h:i A"), new \DateTimeZone($tz0));

                $time_from_t1->setTimezone(new \DateTimeZone($tz));
                $time_to_t1->setTimezone(new \DateTimeZone($tz));

                $tf_time    = $time_from_t1->format("h:i A");
                $tt_time    = $time_to_t1->format("h:i A");

                $day[$t_av->day][] = array('from'=>$tf_time,'to'=>$tt_time,'check'=>$find_to,'f1'=>$t_av->time_from,'t1'=>$t_av->time_to);
            }
        }
        // dd($day);

        $s_date = strtotime(date('Y-m-d h:i a'));
        for($i=0;$i<=30;$i++)
        {
            $c_date = date('Y-m-d h:i A',strtotime('+'.$i.' days', $s_date));
            $d_date = date('D',strtotime('+'.$i.' days', $s_date));
            $d_date = strtolower($d_date);
            if(isset($day[$d_date]) && count($day[$d_date])>0)
            {
                foreach($day[$d_date] as $da)
                {
                    $s_time_01 = date('Y-m-d',strtotime($c_date)).' '.$da['from'];
                    $e_time_01 = date('Y-m-d',strtotime($c_date)).' '.$da['to'];

                    $start  = date('Y-m-d',strtotime($s_time_01)).'T'.date('H:i:00',strtotime($s_time_01));
                    $cate   = date('d M Y',strtotime($s_time_01)).' at '.date('h:i A',strtotime($s_time_01));
                    $end    = date('Y-m-d',strtotime($e_time_01)).'T'.date('H:i:00',strtotime($e_time_01));

                    $timeCom= strtotime(date('Y-m-d H:i',strtotime('+5 hour',$s_date)));
                    $timeCom2= strtotime($s_time_01);

                    if($timeCom < $timeCom2)
                    {
                        $s_time_02 = date('Y-m-d',strtotime($c_date)).' '.$da['from'];
                        //time convert into UTC
                        $time_from_t1   = new \DateTime($s_time_02, new \DateTimeZone($tz));
                        $time_from_t1->setTimezone(new \DateTimeZone('UTC'));
                        $s_time_02    = $time_from_t1->format("Y-m-d h:i A");

                        $check  = BookSession::whereDate('start_time',date('Y-m-d',strtotime($s_time_02)))
                                            ->whereTime('start_time',date('H:i:00',strtotime($s_time_02)))
                                            ->first();

                                            // dd($s_time_02);
                        if($check==null)
                        {
                            $events[] = array(  'id'        =>'1',
                                        'calendarId'=> 'cal1',
                                        'title'     => 'Available Slot',
                                        'body'      => $cate,
                                        'start'     => $start,
                                        'end'       => $end,
                                        'location'  => 'Meeting Room A',
                                        'attendees' => ['A', 'B', 'C'],
                                        'category'  => 'time',
                                        'state'     => 'Free',
                                        'color'     => '#fff',
                                        'text01'    => $cate,
                                        'backgroundColor' => 'green',
                                    );
                        }

                    }

                }
            }

        }
        // dd($events);

        $html = view('front.cal',compact('events','tz','tz1'))->render();
        return json_encode(['status'=>true,'html'=>$html]);
    }

    public function cal_data(Request $request)
    {
        // dd('here');
        // date_default_timezone_set("Europe/Paris");
        $credit_value = Credit::where(['user_id'=>Auth::user()->id,'class_id'=>$request->c_id])->first();
        $credit = $credit_value->credit;
        // dd($credit);
        $tz_f   = Auth::user()->load('StudentDetail.TimeZone');
        // dd($tz_f);
        $tz     = ($tz_f->StudentDetail != null && $tz_f->StudentDetail->TimeZone!=null)?$tz_f->StudentDetail->TimeZone->timezone:'Europe/Berlin';
        $tz1    = ($tz_f->StudentDetail != null && $tz_f->StudentDetail->TimeZone!=null)?$tz_f->StudentDetail->TimeZone->raw_offset:'1.00';
        date_default_timezone_set($tz);

        $class_id   = $request->c_id;
        $teacher_id = $request->t_id;
        $c_detail   = Pricing::where('id',$class_id)->first();
        $teacher_av = Availability::where('user_id',$teacher_id)->get();
        $interval   = ($c_detail!=null && $c_detail->time!=null)?$c_detail->time:'00';
        $interval   = (int)$interval;
        $day        = array();
        $events     = array();
        // dd($teacher_av);
        foreach($teacher_av as $t_av)
        {

            $startTime  = new \DateTime(date('Y-m-d').' '.$t_av->time_from, new \DateTimeZone('UTC'));
            $startTime->setTimezone(new \DateTimeZone($tz));
            $endTime    = new \DateTime(date('Y-m-d').' '.$t_av->time_to, new \DateTimeZone('UTC'));
            $endTime->setTimezone(new \DateTimeZone($tz));

            if($startTime > $endTime)
            {
                // dd('yes ');
                // $startTime  = new \DateTime(date('Y-m-d').' '.$startTime->format('H:i:s'));
                // $endTime    = new \DateTime(date('Y-m-d').' '.$endTime->format('H:i:s'));
                $endTime = $endTime->modify('+1 day');
            }

            // dd(date('Y-m-d').' '.$t_av->time_from,date('Y-m-d').' '.$t_av->time_to);
            // dd($startTime,$endTime);
            while ($startTime < $endTime) {
                $st = $startTime->format('H:i:s');
                $et = $startTime->modify('+'.$interval.' minutes');
                $et2= $et->format('Y-m-d H:i:s');
                // echo strtotime($et2).'<='.strtotime($endTime->format('Y-m-d H:i:s')).'<br>';
                if(strtotime($et2)<=strtotime($endTime->format('Y-m-d H:i:s')))
                {
                    // echo $st.'='.$et->format('H:i:s').''.strtotime($et2).'<br>';
                    $day[$t_av->day][] = array('from'=>$st,'to'=>$et->format('H:i:s'),'check'=>'','f1'=>$st,'t1'=>$et->format('H:i:s'));
                }
            }
            // dd($day);

        }
        // dd($day);

        $s_date = strtotime(date('Y-m-d h:i a'));
        for($i=0;$i<=60;$i++)
        {
            $c_date = date('Y-m-d h:i A',strtotime('+'.$i.' days', $s_date));

            $d_date = date('D',strtotime('+'.$i.' days', $s_date));
            $d_date = strtolower($d_date);
            if(isset($day[$d_date]) && count($day[$d_date])>0)
            {
                foreach($day[$d_date] as $da)
                {
                    $s_time_01 = date('Y-m-d',strtotime($c_date)).' '.$da['from'];
                    $e_time_01 = date('Y-m-d',strtotime($c_date)).' '.$da['to'];

                    $start  = date('Y-m-d',strtotime($s_time_01)).'T'.date('H:i:00',strtotime($s_time_01));
                    $cate   = date('d M Y',strtotime($s_time_01)).' at '.date('h:i A',strtotime($s_time_01));
                    $end    = date('Y-m-d',strtotime($e_time_01)).'T'.date('H:i:00',strtotime($e_time_01));

                    $timeCom= strtotime(date('Y-m-d H:i',strtotime('+24 hour',$s_date)));
                    $timeCom2= strtotime($s_time_01);
 
                    if($timeCom < $timeCom2)
                    {
                        $s_time_02 = date('Y-m-d',strtotime($c_date)).' '.$da['from'];
                        $e_time_02 = date('Y-m-d',strtotime($c_date)).' '.$da['to'];
                        //time convert into UTC
                        $time_from_t1   = new \DateTime($s_time_02, new \DateTimeZone($tz));
                        $time_from_t1->setTimezone(new \DateTimeZone('UTC'));
                        $s_time_02    = $time_from_t1->format("Y-m-d h:i A");

                        $time_to_t1   = new \DateTime($e_time_02, new \DateTimeZone($tz));
                        $time_to_t1->setTimezone(new \DateTimeZone('UTC'));
                        $e_time_02    = $time_to_t1->format("Y-m-d h:i A");

                        $check  = BookSession::where('teacher_id',$teacher_id)
                                                // ->where('end_time','>=',date('Y-m-d H:i:00',strtotime($e_time_02)))
                                            // where(function($qry) use($s_time_02,$e_time_02){
                                            //     $qry->whereDate('start_time','>=',date('Y-m-d',strtotime($s_time_02)))
                                            //         ->whereTime('start_time','>=',date('H:i:00',strtotime($s_time_02)));
                                            //     $qry->whereDate('end_time','>=',date('Y-m-d',strtotime($e_time_02)))
                                            //         ->whereTime('end_time','>=',date('H:i:00',strtotime($e_time_02)));
                                            // })
                                            ->where(function($qry) use($s_time_02,$e_time_02) {
                                                $qry->where(function($query) use($s_time_02,$e_time_02) {
                                                    $query->where('start_time','>=',date('Y-m-d H:i',strtotime($s_time_02)))
                                                            ->where('end_time','>=',date('Y-m-d H:i',strtotime($e_time_02)))
                                                            ->where('start_time','<=',date('Y-m-d H:i',strtotime($e_time_02)));
                                                            // ->where('start_time','>=',date('Y-m-d H:i',strtotime($s_time_02)));
                                                })
                                                ->orWhere(function($query) use($s_time_02,$e_time_02) {
                                                    $query->where('start_time','<=',date('Y-m-d H:i',strtotime($s_time_02)))
                                                            ->where('end_time','<',date('Y-m-d H:i',strtotime($e_time_02)))
                                                            ->where('end_time','>',date('Y-m-d H:i',strtotime($s_time_02)));
                                                            // ->where('end_time','<=',date('Y-m-d H:i',strtotime($e_time_02)));
                                                })
                                                ->orWhere(function($query) use($s_time_02,$e_time_02) {
                                                    $query->where('start_time','>=',date('Y-m-d H:i',strtotime($s_time_02)))
                                                            ->where('end_time','<=',date('Y-m-d H:i',strtotime($e_time_02)));
                                                })
                                                ->orWhere(function($query) use($s_time_02,$e_time_02) {
                                                    $query->where('start_time','<=',date('Y-m-d H:i',strtotime($s_time_02)))
                                                            ->where('end_time','>=',date('Y-m-d H:i',strtotime($e_time_02)));
                                                });
                                            })->where('is_cancelled',0)
                                            ->first();


                                            // dd($s_time_02);
                        $unavailable = Unavailability::where('teacher_id',$teacher_id)
                                        // where(function($qry) use($s_time_02,$e_time_02){
                                        //     $qry->where('start_time','>=',date('Y-m-d H:i',strtotime($s_time_02)))
                                        //         ->where('end_time','>=',date('Y-m-d H:i',strtotime($s_time_02)))
                                        // })
                                        ->where(function($qry) use($s_time_02,$e_time_02) {
                                            // $qry->where(function($query) use($s_time_02,$e_time_02) {
                                            //     $query->where('start_time','>=',date('Y-m-d H:i',strtotime($s_time_02)))
                                            //             ->where('end_time','>=',date('Y-m-d H:i',strtotime($e_time_02)))
                                            //             ->where('start_time','<=',date('Y-m-d H:i',strtotime($e_time_02)));
                                            //             // ->where('start_time','>=',date('Y-m-d H:i',strtotime($s_time_02)));
                                            // })
                                            $qry->where(function($query) use($s_time_02,$e_time_02) {
                                                $query->where('start_time','<=',date('Y-m-d H:i',strtotime($s_time_02)))
                                                        ->where('end_time','<',date('Y-m-d H:i',strtotime($e_time_02)))
                                                        ->where('end_time','>',date('Y-m-d H:i',strtotime($s_time_02)));
                                                        // ->where('end_time','<=',date('Y-m-d H:i',strtotime($e_time_02)));
                                            })
                                            ->orWhere(function($query) use($s_time_02,$e_time_02) {
                                                $query->where('start_time','>=',date('Y-m-d H:i',strtotime($s_time_02)))
                                                        ->where('end_time','<=',date('Y-m-d H:i',strtotime($e_time_02)));
                                            })
                                            ->orWhere(function($query) use($s_time_02,$e_time_02) {
                                                $query->where('start_time','<=',date('Y-m-d H:i',strtotime($s_time_02)))
                                                        ->where('end_time','>=',date('Y-m-d H:i',strtotime($e_time_02)));
                                            });
                                        })
                                        ->first();
                        // if(date('d',strtotime($s_time_02))==26) { dd($check,$unavailable); }
                        if($check==null && $unavailable==null)
                        {
                            $events[] = array(  'id'        =>'1',
                                        'calendarId'=> 'cal1',
                                        'title'     => 'Available Slot',
                                        'body'      => $cate,
                                        'start'     => $start,
                                        'end'       => $end,
                                        'location'  => 'Meeting Room A',
                                        'attendees' => ['A', 'B', 'C'],
                                        'category'  => 'time',
                                        'state'     => 'Free',
                                        'color'     => '#fff',
                                        'text01'    => $cate,
                                        'backgroundColor' => 'green',
                                        'hereText'   => 'TEXT TEST',
                                    );
                        }

                        // if($unavailable!=null)
                        // {
                        //     $b_time_from   = new \DateTime($unavailable->start_time, new \DateTimeZone('UTC'));
                        //     $b_time_to     = new \DateTime($unavailable->end_time, new \DateTimeZone('UTC'));

                        //     $b_time_from->setTimezone(new \DateTimeZone($tz));
                        //     $b_time_to->setTimezone(new \DateTimeZone($tz));

                        //     $tf_time    = $b_time_from->format("Y-m-d H:i");
                        //     $tt_time    = $b_time_to->format("Y-m-d H:i");

                        //     $events[] = array(  'id'        =>'1',
                        //                     'calendarId'=> 'cal1',
                        //                     'title'     => 'Unavailable',
                        //                     'body'      => '',
                        //                     'start'     => str_replace(' ','T',$tf_time),
                        //                     'end'       => str_replace(' ','T',$tt_time),
                        //                     'location'  => 'Meeting Room A',
                        //                     'attendees' => ['B', 'B' , 'C'],
                        //                     'category'  => 'time',
                        //                     'state'     => 'Free',
                        //                     'color'     => '#fff',
                        //                     'text01'    => '',
                        //                     'backgroundColor' => 'red',
                        //                     'customStyle' => [
                        //                         'z-index' => '999999',
                        //                     ],
                        //                 );
                        // }

                    }

                }
            }

        }
        //Find Unavailability
        // date_default_timezone_set('UTC');
        // $unavailable = Unavailability::where('teacher_id',$teacher_id)->where('start_time','>=',date('Y-m-d H:i:00'))->get();
        // // dd($unavailable);
        // date_default_timezone_set($tz);
        // foreach($unavailable as $un)
        // {
        //     $b_time_from   = new \DateTime($un->start_time, new \DateTimeZone('UTC'));
        //                     $b_time_to     = new \DateTime($un->end_time, new \DateTimeZone('UTC'));

        //                     $b_time_from->setTimezone(new \DateTimeZone($tz));
        //                     $b_time_to->setTimezone(new \DateTimeZone($tz));

        //                     $tf_time    = $b_time_from->format("Y-m-d H:i");
        //                     $tt_time    = $b_time_to->format("Y-m-d H:i");

        //     $events[] = array(  'id'        =>'1',
        //                     'calendarId'=> 'cal1',
        //                     'title'     => 'Unavailable',
        //                     'body'      => '',
        //                     'start'     => str_replace(' ','T',$tf_time),
        //                     'end'       => str_replace(' ','T',$tt_time),
        //                     'location'  => 'Meeting Room A',
        //                     'attendees' => ['B', 'B' , 'C'],
        //                     'category'  => 'time',
        //                     'state'     => 'Free',
        //                     'color'     => '#fff',
        //                     'text01'    => '',
        //                     'backgroundColor' => 'red',
        //                     'customStyle' => [
        //                         'z-index' => '999999',
        //                     ],
        //                 );
        // }
        // dd($events);

        $html = view('front.cal',compact('events','tz','tz1'))->render();
        return json_encode(['status'=>true,'html'=>$html,'credit'=>$credit]);
    }

    public function book_session(Request $req)
    {
        // dd($req->all());
        $date_time1 = explode(',',$req->date_time);
        for($i=0; $i < count($date_time1); $i++){
            $tz_f   = Auth::user()->load('StudentDetail.TimeZone');
            $tz     = ($tz_f->StudentDetail != null && $tz_f->StudentDetail->TimeZone!=null)?$tz_f->StudentDetail->TimeZone->timezone:'Europe/Berlin';
            $tz1    = ($tz_f->StudentDetail != null && $tz_f->StudentDetail->TimeZone!=null)?$tz_f->StudentDetail->TimeZone->raw_offset:'1.00';

            $date_time  = str_replace('at ','',$date_time1[$i]);

            $time_from_t1   = new \DateTime($date_time, new \DateTimeZone($tz));
            $time_from_t1->setTimezone(new \DateTimeZone('UTC'));
            $tf_time        = $time_from_t1->format("Y-m-d h:i A");

            $c_detail   = Pricing::where('id',$req->get('class_id'))->first();

            $start_time = date('Y-m-d H:i',strtotime($tf_time));
            $interval   = ($c_detail!=null && $c_detail->time!=null)?$c_detail->time:'00';
            $end_time   = date('Y-m-d H:i',strtotime('+'.$interval.' minutes',strtotime($tf_time)));

            $insert_arr = array(    'class_id'      => $req->get('class_id'),
                                    'student_id'    => $req->get('student_id'),
                                    'teacher_id'    => $req->get('teacher_id'),
                                    'student_date'  => date('Y-m-d H:i',strtotime($date_time)),
                                    'start_time'    => $start_time,
                                    'end_time'      => $end_time,
                                    'duration'      => $interval,
                                    'created_at'    => Carbon::now()
                                );

            $insert_id  = BookSession::create($insert_arr)->id;
            if($insert_id!=null)
            {
                $this->merithub_create_class1($insert_id);
                // $url = route('student.book.session.merithub',$insert_id);
                // return json_encode(['status'=>true,'msg'=>'Booking Successfull','url'=>$url]);
            }
            else{
                return json_encode(['status'=>false,'msg'=>'Oops something went wrong']);
            }
        }
        return json_encode(['status'=>true,'msg'=>'Booking Successfull']);

    }

    // public function merithub_create_class(Request $req)
    // {
    //     echo 'here implement and redirect to my-classis';
    // }
    public function merithub_create_class1($book_id)
    {
        // dd($request->all());
        $check = BookSession::find($book_id);
        // dd($check);
        if($check!=null)
        {
            DB::beginTransaction();
            try{
                    //MeritHubIntegration here
                    $merithub  = DB::table('merithub_creditionals')->first();
                    $t_user    = DB::table('users')->where('id',$check->teacher_id)->first();
                    $s_user    = DB::table('users')->where('id',$check->student_id)->first();
                    $tutor     = DB::table('teacher_settings')->where('user_id',$check->teacher_id)->first();
                    $tutor_img = ($tutor!=null && $tutor->avatar!=null)? url('uploads/user/avatar/').'/'.$tutor->avatar:'https://classes.latogo.de/assets/img/fav.png';

                    $student   = DB::table('student_details')->where('user_id',$check->student_id)->first();
                    $student_img = ($student!=null && $student->avtar!=null)? url('uploads/user/avatar/').'/'.$student->avtar:'https://classes.latogo.de/assets/img/fav.png';


                    // dd($tutor_img,$student_img);
                    $tt        = ($tutor!=null && $tutor->timezone!=null)?$tutor->timezone:'136';
                    $timezone1 = DB::table('time_zones')->where('id',$tt)->first();
                    $st        = ($student!=null && $student->timezone!=null)?$student->timezone:'136';
                    $timezone  = DB::table('time_zones')->where('id',$st)->first();
                    $timesx     = $check->start_time;

                    $tz        = $timezone->timezone;

                    $t1        = new \DateTime($timesx, new \DateTimeZone('UTC'));
                    $t1->setTimezone(new \DateTimeZone($tz));
                    $times     = $t1->format("Y-m-d h:i A");

                    $t2        = new \DateTime($timesx, new \DateTimeZone('UTC'));
                    $t2->setTimezone(new \DateTimeZone($timezone1->timezone));
                    $times2    = $t2->format("Y-m-d h:i A");

                    $startTime = date('Y-m-d',(strtotime($times))).'T'.date('H:i:s',(strtotime($times)));

                    $headers   = array("content-type: application/json", "Authorization:".$merithub->merithub_token);


                    if(empty($t_user->mh_user_id))
                    {
                        $url    = "https://serviceaccount1.meritgraph.com/v1/".$merithub->client_id."/users";
                        $data   = array("name"=>$t_user->name,
                                        "img"=> $tutor_img,
                                        "lang"=>"en",
                                        "clientUserId"=>"LATOGO-".$t_user->id,
                                        "email"=>$t_user->email,
                                        "role"=>"M",
                                        "timeZoneId"=>$timezone1->timezone,
                                        "permission"=>"CJ"
                                    );

                        $post_data  = json_encode($data);

                        $curl       = curl_init($url);
                        curl_setopt($curl, CURLOPT_URL, $url);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1 );
                        curl_setopt($curl, CURLOPT_POST, 1);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
                        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                        $result = curl_exec($curl);
                        curl_close($curl);

                        $getUserId      = json_decode($result);
                        $mh_user_id     = $getUserId->userId;
                        $update         = DB::table('users')->where('id', $t_user->id)->update(['mh_user_id'=>$mh_user_id]);
                    }
                    else
                    {
                        $mh_user_id = $t_user->mh_user_id;

                        $this->meritHubUserUpdate($merithub->client_id, $mh_user_id, $tutor_img, $timezone1->timezone, $t_user, $headers);
                        // die('end');
                    }

                    if(empty($s_user->mh_user_id))
                    {
                        $url2   = "https://serviceaccount1.meritgraph.com/v1/".$merithub->client_id."/users";

                        $data2  = array("name"=>$s_user->name,
                                        "img"=> $student_img,
                                        "lang"=>"en",
                                        "clientUserId"=>"LATOGO-".$s_user->id,
                                        "email"=>$s_user->email,
                                        "role"=>"M",
                                        "timeZoneId"=>$timezone->timezone,
                                        "permission"=>"CJ"
                                    );

                        $post_data2 = json_encode($data2);

                        $curl2      = curl_init($url2);
                        curl_setopt($curl2, CURLOPT_URL, $url2);
                        curl_setopt($curl2, CURLOPT_RETURNTRANSFER, 1 );
                        curl_setopt($curl2, CURLOPT_POST, 1);
                        curl_setopt($curl2, CURLOPT_POSTFIELDS, $post_data2);
                        curl_setopt($curl2, CURLOPT_HTTPHEADER, $headers);
                        $result2 = curl_exec($curl2);
                        curl_close($curl2);

                        $getUserId2  = json_decode($result2);
                        $mh_user_id2 = $getUserId2->userId;
                        $update      = DB::table('users')->where('id', $s_user->id)->update(['mh_user_id'=>$mh_user_id2]);
                    }
                    else
                    {
                        $mh_user_id2 = $s_user->mh_user_id;

                        $this->meritHubUserUpdate($merithub->client_id, $mh_user_id2, $student_img, $timezone->timezone, $s_user, $headers);
                    }

                    // Schedule Class CURL
                    $url1     = "https://class1.meritgraph.com/v1/".$merithub->client_id."/".$mh_user_id."";

                    $data1 = array( "title"=>$s_user->name.' '.'Session',
                                    "startTime"=>$startTime,
                                    "recordingDownload"=>true,
                                    "downloadRecording"=>true,
                                    "duration"=>$check->duration,
                                    "lang"=>"en",
                                    "timeZoneId"=>$timezone->timezone,
                                    "type"=>"oneTime",
                                    "access"=>"private",
                                    "login"=>false,
                                    "layout"=>"CR",
                                    "status"=>"up",
                                    "recording"=>array("record"=>true,"autoRecord"=>true,"recordingControl"=>true)
                                );

                    $post_data1 = json_encode($data1);
                    $curl1 = curl_init($url1);
                    curl_setopt($curl1, CURLOPT_URL, $url1);
                    curl_setopt($curl1, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl1, CURLOPT_POST, 1);
                    curl_setopt($curl1, CURLOPT_POSTFIELDS, $post_data1);
                    curl_setopt($curl1, CURLOPT_HTTPHEADER, $headers);
                    $result1 = curl_exec($curl1);
                    curl_close($curl1);

                    $getClass = json_decode($result1);
                                // dd($getClass);
                    $classId               = $getClass->classId;
                    $TutorJoinLink         = $getClass->hostLink;
                    $commonParticipantLink = $getClass->commonLinks->commonParticipantLink;
                    // End Schedule Class CURL

                    $url3       = "https://class1.meritgraph.com/v1/".$merithub->client_id."/".$classId."/users";
                    $data3      = array("users"=>array(array("userId"=>$mh_user_id2,"userLink"=>$commonParticipantLink,"userType"=>"su","timeZoneId"=>$timezone1->timezone,)));
                    $post_data3 = json_encode($data3);

                    $curl3      = curl_init($url3);
                    curl_setopt($curl3, CURLOPT_URL, $url3);
                    curl_setopt($curl3, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl3, CURLOPT_POST, 1);
                    curl_setopt($curl3, CURLOPT_POSTFIELDS, $post_data3);
                    curl_setopt($curl3, CURLOPT_HTTPHEADER, $headers);
                    $result3 = curl_exec($curl3);
                    curl_close($curl3);
                    $getSession = json_decode($result3);
                    $StudentJoinLink = $getSession[0]->userLink;

                    $TutorJoinLink   = "https://live.merithub.com/info/room/".$merithub->client_id."/".$TutorJoinLink;
                    $StudentJoinLink = "https://live.merithub.com/info/room/".$merithub->client_id."/".$StudentJoinLink;
                    $RecordingURL    = "https://merithub.com/".$merithub->client_id."/sessions/view/".$classId."/".$commonParticipantLink;
                    // End MerihHub Integration

                    //Decrease credit
                    Credit::where(['user_id'=>auth()->user()->id,'class_id'=>$check->class_id])->decrement('credit',1);

                    // Update book Session
                    $check->merithub_class_id = $classId;
                    $check->student_url = $StudentJoinLink;
                    $check->teacher_url = $TutorJoinLink;
                    $check->record_url  = $RecordingURL;
                    $check->is_booked   = 1;
                    $check->save();


                    // Email for student


                    $email =
                    [
                    'sender_email' => $s_user->email,
                    'inext_email' => env('MAIL_USERNAME'),
                    'name' => $s_user->name,
                    'title' => 'Successfully Registered!',
                    'class_time' => $times,
                    'class_durection' => $check->duration
                    ];

                    Mail::send('email.student-when-book-a-class', $email, function ($messages) use ($email) {
                        $messages->to($email['sender_email'])
                        ->from($email['inext_email'], 'Latogo');
                        $messages->subject("Latogo Class Confirmation");
                    });

                    //Email for Teacher
                    $email2 =
                    [
                    'sender_email' => $t_user->email,
                    'inext_email' => env('MAIL_USERNAME'),
                    'name' => $t_user->name,
                    's_name' => $s_user->name,
                    'title' => 'Successfully Registered!',
                    'class_time' => $times2,
                    'class_durection' => $check->duration
                    ];

                    Mail::send('email.when-student-book-a-lesson-then-need-to-send-email-to-teacher', $email2, function ($messages) use ($email2) {
                        $messages->to($email2['sender_email'])
                        ->from($email2['inext_email'], 'Latogo');
                        $messages->subject("Latogo Class Confirmation");
                    });

                    DB::commit();
                    return redirect()->route('student.my-classes')->with('success','Class created successfully.');

            }
            catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                echo '<b>ERROR : </b>'.$e; //$e->getMessage()
                die;
            }

        }
        else
        {
            return redirect()->route('student.my-classes')->with('error','Oops something went wrong');
        }
    
    }
    public function merithub_create_class(Request $request)
    {
        // dd($request->id);
        $check = BookSession::find($request->id);
        if($check!=null)
        {
            DB::beginTransaction();
            try{
                    //MeritHubIntegration here
                    $merithub  = DB::table('merithub_creditionals')->first();
                    $t_user    = DB::table('users')->where('id',$check->teacher_id)->first();
                    $s_user    = DB::table('users')->where('id',$check->student_id)->first();
                    $tutor     = DB::table('teacher_settings')->where('user_id',$check->teacher_id)->first();
                    $tutor_img = ($tutor!=null && $tutor->avatar!=null)? url('uploads/user/avatar/').'/'.$tutor->avatar:'https://classes.latogo.de/assets/img/fav.png';

                    $student   = DB::table('student_details')->where('user_id',$check->student_id)->first();
                    $student_img = ($student!=null && $student->avtar!=null)? url('uploads/user/avatar/').'/'.$student->avtar:'https://classes.latogo.de/assets/img/fav.png';


                    // dd($tutor_img,$student_img);
                    $tt        = ($tutor!=null && $tutor->timezone!=null)?$tutor->timezone:'136';
                    $timezone1 = DB::table('time_zones')->where('id',$tt)->first();
                    $st        = ($student!=null && $student->timezone!=null)?$student->timezone:'136';
                    $timezone  = DB::table('time_zones')->where('id',$st)->first();
                    $timesx     = $check->start_time;

                    $tz        = $timezone->timezone;

                    $t1        = new \DateTime($timesx, new \DateTimeZone('UTC'));
                    $t1->setTimezone(new \DateTimeZone($tz));
                    $times     = $t1->format("Y-m-d h:i A");

                    $t2        = new \DateTime($timesx, new \DateTimeZone('UTC'));
                    $t2->setTimezone(new \DateTimeZone($timezone1->timezone));
                    $times2    = $t2->format("Y-m-d h:i A");

                    $startTime = date('Y-m-d',(strtotime($times))).'T'.date('H:i:s',(strtotime($times)));

                    $headers   = array("content-type: application/json", "Authorization:".$merithub->merithub_token);


                    if(empty($t_user->mh_user_id))
                    {
                        $url    = "https://serviceaccount1.meritgraph.com/v1/".$merithub->client_id."/users";
                        $data   = array("name"=>$t_user->name,
                                        "img"=> $tutor_img,
                                        "lang"=>"en",
                                        "clientUserId"=>"LATOGO-".$t_user->id,
                                        "email"=>$t_user->email,
                                        "role"=>"M",
                                        "timeZoneId"=>$timezone1->timezone,
                                        "permission"=>"CJ"
                                    );

                        $post_data  = json_encode($data);

                        $curl       = curl_init($url);
                        curl_setopt($curl, CURLOPT_URL, $url);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1 );
                        curl_setopt($curl, CURLOPT_POST, 1);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
                        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                        $result = curl_exec($curl);
                        curl_close($curl);

                        $getUserId      = json_decode($result);
                        $mh_user_id     = $getUserId->userId;
                        $update         = DB::table('users')->where('id', $t_user->id)->update(['mh_user_id'=>$mh_user_id]);
                    }
                    else
                    {
                        $mh_user_id = $t_user->mh_user_id;

                        $this->meritHubUserUpdate($merithub->client_id, $mh_user_id, $tutor_img, $timezone1->timezone, $t_user, $headers);
                        // die('end');
                    }

                    if(empty($s_user->mh_user_id))
                    {
                        $url2   = "https://serviceaccount1.meritgraph.com/v1/".$merithub->client_id."/users";

                        $data2  = array("name"=>$s_user->name,
                                        "img"=> $student_img,
                                        "lang"=>"en",
                                        "clientUserId"=>"LATOGO-".$s_user->id,
                                        "email"=>$s_user->email,
                                        "role"=>"M",
                                        "timeZoneId"=>$timezone->timezone,
                                        "permission"=>"CJ"
                                    );

                        $post_data2 = json_encode($data2);

                        $curl2      = curl_init($url2);
                        curl_setopt($curl2, CURLOPT_URL, $url2);
                        curl_setopt($curl2, CURLOPT_RETURNTRANSFER, 1 );
                        curl_setopt($curl2, CURLOPT_POST, 1);
                        curl_setopt($curl2, CURLOPT_POSTFIELDS, $post_data2);
                        curl_setopt($curl2, CURLOPT_HTTPHEADER, $headers);
                        $result2 = curl_exec($curl2);
                        curl_close($curl2);

                        $getUserId2  = json_decode($result2);
                        $mh_user_id2 = $getUserId2->userId;
                        $update      = DB::table('users')->where('id', $s_user->id)->update(['mh_user_id'=>$mh_user_id2]);
                    }
                    else
                    {
                        $mh_user_id2 = $s_user->mh_user_id;

                        $this->meritHubUserUpdate($merithub->client_id, $mh_user_id2, $student_img, $timezone->timezone, $s_user, $headers);
                    }

                    // Schedule Class CURL
                    $url1     = "https://class1.meritgraph.com/v1/".$merithub->client_id."/".$mh_user_id."";

                    $data1 = array( "title"=>$s_user->name.' '.'Session',
                                    "startTime"=>$startTime,
                                    "recordingDownload"=>true,
                                    "downloadRecording"=>true,
                                    "duration"=>$check->duration,
                                    "lang"=>"en",
                                    "timeZoneId"=>$timezone->timezone,
                                    "type"=>"oneTime",
                                    "access"=>"private",
                                    "login"=>false,
                                    "layout"=>"CR",
                                    "status"=>"up",
                                    "recording"=>array("record"=>true,"autoRecord"=>true,"recordingControl"=>true)
                                );

                    $post_data1 = json_encode($data1);
                    $curl1 = curl_init($url1);
                    curl_setopt($curl1, CURLOPT_URL, $url1);
                    curl_setopt($curl1, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl1, CURLOPT_POST, 1);
                    curl_setopt($curl1, CURLOPT_POSTFIELDS, $post_data1);
                    curl_setopt($curl1, CURLOPT_HTTPHEADER, $headers);
                    $result1 = curl_exec($curl1);
                    curl_close($curl1);

                    $getClass = json_decode($result1);
                                // dd($getClass);
                    $classId               = $getClass->classId;
                    $TutorJoinLink         = $getClass->hostLink;
                    $commonParticipantLink = $getClass->commonLinks->commonParticipantLink;
                    // End Schedule Class CURL

                    $url3       = "https://class1.meritgraph.com/v1/".$merithub->client_id."/".$classId."/users";
                    $data3      = array("users"=>array(array("userId"=>$mh_user_id2,"userLink"=>$commonParticipantLink,"userType"=>"su","timeZoneId"=>$timezone1->timezone,)));
                    $post_data3 = json_encode($data3);

                    $curl3      = curl_init($url3);
                    curl_setopt($curl3, CURLOPT_URL, $url3);
                    curl_setopt($curl3, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl3, CURLOPT_POST, 1);
                    curl_setopt($curl3, CURLOPT_POSTFIELDS, $post_data3);
                    curl_setopt($curl3, CURLOPT_HTTPHEADER, $headers);
                    $result3 = curl_exec($curl3);
                    curl_close($curl3);
                    $getSession = json_decode($result3);
                    $StudentJoinLink = $getSession[0]->userLink;

                    $TutorJoinLink   = "https://live.merithub.com/info/room/".$merithub->client_id."/".$TutorJoinLink;
                    $StudentJoinLink = "https://live.merithub.com/info/room/".$merithub->client_id."/".$StudentJoinLink;
                    $RecordingURL    = "https://merithub.com/".$merithub->client_id."/sessions/view/".$classId."/".$commonParticipantLink;
                    // End MerihHub Integration

                    //Decrease credit
                    Credit::where(['user_id'=>auth()->user()->id,'class_id'=>$check->class_id])->decrement('credit',1);

                    // Update book Session
                    $check->merithub_class_id = $classId;
                    $check->student_url = $StudentJoinLink;
                    $check->teacher_url = $TutorJoinLink;
                    $check->record_url  = $RecordingURL;
                    $check->is_booked   = 1;
                    $check->save();


                    // Email for student


                    $email =
                    [
                    'sender_email' => $s_user->email,
                    'inext_email' => env('MAIL_USERNAME'),
                    'name' => $s_user->name,
                    'title' => 'Successfully Registered!',
                    'class_time' => $times,
                    'class_durection' => $check->duration
                    ];

                    Mail::send('email.student-when-book-a-class', $email, function ($messages) use ($email) {
                        $messages->to($email['sender_email'])
                        ->from($email['inext_email'], 'Latogo');
                        $messages->subject("Latogo Class Confirmation");
                    });

                    //Email for Teacher
                    $email2 =
                    [
                    'sender_email' => $t_user->email,
                    'inext_email' => env('MAIL_USERNAME'),
                    'name' => $t_user->name,
                    's_name' => $s_user->name,
                    'title' => 'Successfully Registered!',
                    'class_time' => $times2,
                    'class_durection' => $check->duration
                    ];

                    Mail::send('email.when-student-book-a-lesson-then-need-to-send-email-to-teacher', $email2, function ($messages) use ($email2) {
                        $messages->to($email2['sender_email'])
                        ->from($email2['inext_email'], 'Latogo');
                        $messages->subject("Latogo Class Confirmation");
                    });

                    DB::commit();
                    return redirect()->route('student.my-classes')->with('success','Class created successfully.');

            }
            catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                echo '<b>ERROR : </b>'.$e; //$e->getMessage()
                die;
            }

        }
        else
        {
            return redirect()->route('student.my-classes')->with('error','Oops something went wrong');
        }
    
    }

    public function meritHubUserUpdate($c_id, $mu_id, $u_img, $tz, $u_data, $headers){

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


    public function cancleclass(Request $request){
        $id = $request->active;
        $user_id = Auth::user()->id;

        DB::beginTransaction();
        try{
            $data = [
                'is_cancelled' => 1,
                'cancelled_by' => $user_id,
            ];

            DB::table('book_sessions')->where('id',$id)->update($data);

            $book_session = BookSession::where('id',$id)->first();
            $teacher = DB::table('users')->where('id',$book_session->teacher_id)->first();
            $pricing = DB::table('pricings')->where('id',$book_session->class_id)->first();
            $price_master = DB::table('price_masters')->where('id',$pricing->price_master)->first();
            $class_name = $price_master->title.' - '.$pricing->totle_class.'x classes - '.$pricing->time.'min';
            $date = $book_session->start_time->format('Y-m-d');
            //teacher time zone according to member
            $t_timezone = DB::table('teacher_settings')->where('user_id',$teacher->id)->first();
            $timezone = DB::table('time_zones')->where('id',$t_timezone->timezone)->first();

            $tz = $timezone->timezone;
            $tz1 = $timezone->raw_offset;

            $date_time  = str_replace('at ','',  $book_session->start_time);
            $time_from_t1   = new \DateTime($date_time, new \DateTimeZone('UTC'));
            $time_from_t1->setTimezone(new \DateTimeZone($tz));
            $start_time = $time_from_t1->format("h:i A");

            $date_time  = str_replace('at ','',  $book_session->end_time);
            $time_from_t1   = new \DateTime($date_time, new \DateTimeZone('UTC'));
            $time_from_t1->setTimezone(new \DateTimeZone($tz));
            $end_time = $time_from_t1->format("h:i A");

            $time = $start_time.' - '.$end_time;

            //now date according to student timezone
            $s_timezone = DB::table('student_details')->where('user_id',$user_id)->first();
            $timezone1 = DB::table('time_zones')->where('id',$s_timezone->timezone)->first();

            $tz3 = $timezone1->timezone;
            $tz2 = $timezone->raw_offset;

            $time_from_t1   = new \DateTime("now",new \DateTimeZone($tz3));
            $time_from_t1->setTimezone(new \DateTimeZone('UTC'));
            $en_time = $time_from_t1->format("Y-m-d h:i A");
            $st_time = $book_session->start_time;
            $to_time = $st_time->diffInHours($en_time);
            // dd($to_time);
            if($to_time > 24){
                $price1 = DB::table('credits')->where('user_id',$book_session->student_id)->where('class_id',$book_session->class_id)->first();
                // dd($price1);
                $data1 = [
                    'credit' => $price1->credit + 1,
                ];
                DB::table('credits')->where('user_id',$book_session->student_id)->where('class_id',$book_session->class_id)->update($data1);
            }

            $email2 =
            [
            'sender_email' => $teacher->email,
            'inext_email' => env('MAIL_USERNAME'),
            't_name' => $teacher->name,
            's_name' => Auth::user()->name,
            'title' => 'Class cancelled!',
            'class_name' => $class_name,
            'class_time' => $time,
            'class_date' => $date
            ];

            Mail::send('email.student-cancle-class', $email2, function ($messages) use ($email2) {
                $messages->to($email2['sender_email'])
                ->from($email2['inext_email'], 'Latogo');
                $messages->subject("Class Cancellation:".$email2['class_date']);
            });

            DB::commit();
            return response()->json([
                'success' => true
            ]);
        }
        catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return $e;
        }

    }

}
