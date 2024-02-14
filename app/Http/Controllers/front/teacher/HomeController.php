<?php

namespace App\Http\Controllers\front\teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Hash;
use File;
use Session;
use App\Models\TeacherSetting;
use App\Models\LanguageMaster;
use App\Models\Message;
use App\Models\Availability;
use App\Models\BookSession;
use App\Models\StudentDetail;
use App\Models\Unavailability;
use Auth;
use DB;
use Validator;
use App\Lib\PusherFactory;
use Mail;
use Event;
use App\Events\SendMail;
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(auth()->user()->id);s
        $country        = DB::table('countries')->get();
        $user           = TeacherSetting::where('user_id',auth()->user()->id)->first();
        $user_country   = DB::table('countries')->where('id',$user->country ?? 82)->first();
        $user_timezone  = DB::table('time_zones')->where('id',$user->timezone ?? 136)->first();

        $date = new \DateTime();
        // $date->setTimezone(new \DateTimeZone($user_timezone->timezone));
        $date->setTimezone(new \DateTimeZone('UTC'));
        $cur_date = $date->format('Y-m-d H:i:s');

        $date2 = new \DateTime();
        $date2->setTimezone(new \DateTimeZone($user_timezone->timezone));
        $cur_time = $date2->format('h:i A');
        // dd($cur_date);
        $upcommit = BookSession::where('teacher_id',auth()->user()->id)
                    // ->whereDate('end_time', '>', $cur_date)
                    ->where('end_time','>=',$cur_date)
                    ->where('student_url','<>',null)
                    // ->orderBy('id','DESC')
                    ->orderBy('start_time','ASC')
                    ->get();

        $past =     BookSession::where('teacher_id',auth()->user()->id)
                    // ->whereDate('end_time', '<', $cur_date)
                    ->where('end_time','<',$cur_date)
                    // ->orderBy('id','DESC')
                    ->orderBy('start_time','ASC')
                    ->get();


        // Chart Data Find
        $day['sun'] = [];
        $day['mon'] = [];
        $day['tue'] = [];
        $day['wed'] = [];
        $day['thu'] = [];
        $day['fri'] = [];
        $day['sat'] = [];
        $chart_c    = [];
        $chart_t    = [];
        $chart_b    = [];

        $times1 = Availability::where(['user_id'=>Auth::user()->id,'day'=>'sun'])->get();
        $times2 = Availability::where(['user_id'=>Auth::user()->id,'day'=>'mon'])->get();
        $times3 = Availability::where(['user_id'=>Auth::user()->id,'day'=>'tue'])->get();
        $times4 = Availability::where(['user_id'=>Auth::user()->id,'day'=>'wed'])->get();
        $times5 = Availability::where(['user_id'=>Auth::user()->id,'day'=>'thu'])->get();
        $times6 = Availability::where(['user_id'=>Auth::user()->id,'day'=>'fri'])->get();
        $times7 = Availability::where(['user_id'=>Auth::user()->id,'day'=>'sat'])->get();

        $teacher_av = Availability::where('user_id',Auth::user()->id)->get();

        foreach($teacher_av as $t_av)
        {
            $day[$t_av->day][] = array('from'=>$t_av->time_from,'to'=>$t_av->time_to,'check'=>'');
        }

        $s_date = strtotime($cur_date);
        for($i=0;$i<=10;$i++)
        {
            $c_date = date('Y-m-d',strtotime('+'.$i.' days', $s_date));
            $d_date = date('D',strtotime('+'.$i.' days', $s_date));
            $d_date = strtolower($d_date);
            if(isset($day[$d_date]) && count($day[$d_date])>0)
            {
                $chart_c[]  = $c_date;
                $chart_t[]  = count($day[$d_date]);
                $chart_b_cnt= 0;
                foreach($day[$d_date] as $da)
                {
                    $s_time_01 = date('Y-m-d',strtotime($c_date)).' '.$da['from'];
                    $e_time_01 = date('Y-m-d',strtotime($c_date)).' '.$da['to'];

                    $check  = BookSession::where('teacher_id',Auth::user()->id)->whereDate('start_time','=',$c_date)
                                            // ->whereTime('start_time',date('H:i:00',strtotime($s_time_01)))
                                            ->count();
                    // if($check!=null)
                    // {
                    //     $chart_b_cnt++;
                    // }

                }
                $chart_b[]=$check;
            }
            else{
                $chart_c[]= $c_date;
            }

        }

        // dd($chart_c,$chart_t,$chart_b);

        return view('front.teacher.dashboard',compact('country','user_country','user_timezone','upcommit','cur_time','chart_c','chart_t','chart_b'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('front.teacher.become-a-teacher');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name'     => 'required|max:255|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
            'email'         => 'required|email|max:255|unique:users,email',
            'mobile_number' => 'required|numeric|min:10',
            'message'       => 'required|max:255',
            'password'      => 'required|min:6|max:255',
            'resume.*'        => 'sometimes|max:5000|mimes:pdf,doc,docx,txt'
        ]);

        $password   = Hash::make($request->input('password'));
        $insert_arr = array('name'      => $request->input('full_name'),
                            'email'     => $request->input('email'),
                            'phone'     => $request->input('mobile_number'),
                            'password'  => $password,
                            'plan_password' => $request->input('password'),
                            'user_type' => 2,
                            'message'   => $request->input('message'),
                            'status'    => 0,
                            'term'      => '1',
                            'created_at'=> Carbon::now(),
                            );

        if($request->hasFile('resume')){
            $path = public_path('upload/resume');
            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }

            $fileName = str_replace(' ','',$request->input('full_name'));
            $fileName = $fileName.'-'.time().'.'.$request->file('resume')->getClientOriginalExtension();
            $request->file('resume')->move($path, $fileName);
            $insert_arr['resume'] = $fileName;
        }

        $email =
        [
        'sender_email' => $request->email,
        'inext_email' => env('MAIL_USERNAME'),
        'sender_name' => $request->full_name,
        'title' => 'Successfully Registered!',
        ];

        Mail::send('email.when-teacher-register-they-will-get-email', $email, function ($messages) use ($email) {
            $messages->to($email['sender_email'])
            ->from($email['inext_email'], 'Latogo');
            $messages->subject("Welcome to Latogo - Let's Begin Your German Language Journey!");
        });

        $insert = User::insert($insert_arr);
        if($insert)
        {
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('front.login')->with('message','Account has been created successfully, Please wait for account activation');
        }
        else{
            return redirect()->back()->with('error','Oops something went wrong');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function setting()
    {
        $id = Auth::user()->id;
        $ts = TeacherSetting::where('user_id',$id)->first();
        $lng= LanguageMaster::where('status',1)->get();

        return view('front.teacher.setting',compact('ts','lng'));
    }

    public function setting_update(Request $request)
    {

        $request->validate([
            'full_name'     => 'required|max:255|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
            'email'         => 'required|email|max:255|unique:users,email,'.Auth::user()->id,
            'phone'         => 'required|numeric|min:10',
            'avatar'        => 'sometimes|max:5000|mimes:png,jpg,jpeg,JPEG',
            'address_line_1'=> 'required',
            'city'          => 'required',
            'zipcode'       => 'required',
            'language'      => 'required',
            'about_me'      => 'required',
            'teacher_headline'      => 'required',
            'me_as_teacher'         => 'required',
            'my_lession_and_teaching_style'      => 'required',
        ]);


        $arr_set = array(   'address_line_1'=> $request->input('address_line_1'),
                            'address_line_2'=> $request->input('address_line_1'),
                            'youtube_link'  => $request->input('intro_video'),
                            'city'          => $request->input('city'),
                            'avatar'        => $request->input('avatat-value'),
                            'zipcode'       => $request->input('zipcode'),
                            'language'      => json_encode($request->input('language')),
                            'about_me'      => $request->input('about_me'),
                            'teacher_headline'  => $request->input('teacher_headline'),
                            'me_as_teacher'     => $request->input('me_as_teacher'),
                            'my_teaching_style' => $request->input('my_lession_and_teaching_style'),
                            'updated_at'        => Carbon::now(),
                        );

        if($request->hasFile('avatar'))
        {
            $path = public_path('uploads/user/avatar');
            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }

            $fileName = str_replace(' ','',$request->input('full_name'));
            $fileName = $fileName.'-'.time().'.'.$request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move($path, $fileName);
            $arr_set['avatar'] = $fileName;
        }

        DB::beginTransaction();

        try{

            $user_update    = User::where('id',Auth::user()->id)->update(['name'=>$request->input('full_name'),'phone'=>$request->input('phone')]);
            $setting_update = TeacherSetting::updateOrCreate(['user_id'=>Auth::user()->id],$arr_set);

            DB::commit();
            return redirect()->back()->with('success','Profile updated successfully!');

        }catch (\Exception $e) {

            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage());
        }


    }

    public function messages(Request $request)
    {
        DB::table('messages')->where(['to_user'=>Auth::user()->id])->update(['is_read'=>1]);
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

        // $users = User::where('id', '!=', Auth::user()->id)->get();
        return view('front.teacher.message', compact('users'));
    }

    public function getLoadLatestMessages(Request $request)
    {
        if(!$request->user_id) {
            return;
        }
        $messages = Message::where(function($query) use ($request) {
            $query->where('from_user', Auth::user()->id)->where('to_user', $request->user_id);
        })->orWhere(function ($query) use ($request) {
            $query->where('from_user', $request->user_id)->where('to_user', Auth::user()->id);
        })->orderBy('created_at', 'ASC')->get();  //->limit(10)
        $return = [];
        foreach ($messages as $message) {
            $return[] = view('front.teacher.message-line')->with('message', $message)->render();
        }

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

        return response()->json(['state' => 1, 'img'=>$img, 'messages' => $return]);
    }


    public function postSendMessage(Request $request)
    {
        if(!$request->to_user || !$request->message) {
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
        if(!$request->old_message_id || !$request->to_user)
            return;
        $message = Message::find($request->old_message_id);
        $lastMessages = Message::where(function($query) use ($request, $message) {
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
        if($lastMessages->count() > 0) {
            foreach ($lastMessages as $message) {
                $return[] = view('front.teacher.message-line')->with('message', $message)->render();
            }
            PusherFactory::make()->trigger('chat', 'oldMsgs', ['to_user' => $request->to_user, 'data' => $return]);
        }
        return response()->json(['state' => 1, 'data' => $return]);
    }

    public function calendar(Request $request)
    {
        $day['sun'] = [];
        $day['mon'] = [];
        $day['tue'] = [];
        $day['wed'] = [];
        $day['thu'] = [];
        $day['fri'] = [];
        $day['sat'] = [];
        $events     = [];

        $user   = TeacherSetting::where('user_id',auth()->user()->id)->first();
        $tz     = DB::table('time_zones')->where('id',$user->timezone ?? 136)->first();
        $tz1    = $tz->raw_offset;
        $tz     = $tz->timezone;

        //Start Find Unavailability
        // date_default_timezone_set('UTC');
        // $unavailable = Unavailability::where('teacher_id',auth()->user()->id)->where('start_time','>=',date('Y-m-d H:i:00'))->orderBy('id','desc')->get();
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
        //     // dd($tf_time,$tt_time);
        //     $events[] = array(  'id'        =>'2',
        //                     'calendarId'=> 'cal1',
        //                     'title'     => 'Unavailable',
        //                     'body'      => '',
        //                     'start'     => str_replace(' ','T',$tf_time),
        //                     'end'       => str_replace(' ','T',$tt_time),
        //                     'location'  => 'Meeting Room A',
        //                     'attendees' => ['A', '' , ''],
        //                     'category'  => 'time',
        //                     'state'     => 'Free',
        //                     'color'     => '#fff',
        //                     'text01'    => '',
        //                     'backgroundColor' => 'red',
        //                 );
        // }
        //End Find Unavailability


        date_default_timezone_set($tz);

        $times1 = Availability::where(['user_id'=>Auth::user()->id,'day'=>'sun'])->get();
        $times2 = Availability::where(['user_id'=>Auth::user()->id,'day'=>'mon'])->get();
        $times3 = Availability::where(['user_id'=>Auth::user()->id,'day'=>'tue'])->get();
        $times4 = Availability::where(['user_id'=>Auth::user()->id,'day'=>'wed'])->get();
        $times5 = Availability::where(['user_id'=>Auth::user()->id,'day'=>'thu'])->get();
        $times6 = Availability::where(['user_id'=>Auth::user()->id,'day'=>'fri'])->get();
        $times7 = Availability::where(['user_id'=>Auth::user()->id,'day'=>'sat'])->get();

        $teacher_av = Availability::where('user_id',Auth::user()->id)->get();

        foreach($teacher_av as $t_av)
        {
            $time_from  = date('Y-m-d').' '.$t_av->time_from;
            $time_to    = date('Y-m-d').' '.$t_av->time_to;

            $time_from_t1   = new \DateTime($time_from, new \DateTimeZone('UTC'));
            $time_to_t1     = new \DateTime($time_to, new \DateTimeZone('UTC'));

            $time_from_t1->setTimezone(new \DateTimeZone($tz));
            $time_to_t1->setTimezone(new \DateTimeZone($tz));

            $tf_time    = $time_from_t1->format("h:i A");
            $tt_time    = $time_to_t1->format("h:i A");

            $day[$t_av->day][] = array('from'=>$tf_time,'to'=>$tt_time,'raw_from'=>$t_av->time_from,'raw_to'=>$t_av->time_to,'check'=>'');
        }
        // dd($day);
        $s_date = strtotime(date('Y-m-d h:i A'));
        for($i=0;$i<=60;$i++)
        {
            $c_date = date('Y-m-d h:i A',strtotime('+'.$i.' days', $s_date));
            $d_date = date('D',strtotime('+'.$i.' days', $s_date));
            $d_date = strtolower($d_date);
            if(isset($day[$d_date]) && count($day[$d_date])>0)
            {
                foreach($day[$d_date] as $da)
                {
                    // dd($da['from']);
                    $s_time_01 = date('Y-m-d',strtotime($c_date)).' '.$da['from'];
                    $e_time_01 = date('Y-m-d',strtotime($c_date)).' '.$da['to'];

                    $s_time_02 = date('Y-m-d',strtotime($c_date)).' '.$da['raw_from'];
                    $e_time_02 = date('Y-m-d',strtotime($c_date)).' '.$da['raw_to'];
                    
                    // dd($s_time_02,$e_time_02);
                    $start  = date('Y-m-d',strtotime($s_time_01)).'T'.date('H:i:00',strtotime($s_time_01));
                    $cate   = date('d M Y',strtotime($s_time_01)).' at '.date('h:i A',strtotime($s_time_01));
                    $end    = date('Y-m-d',strtotime($e_time_01)).'T'.date('H:i:00',strtotime($e_time_01));

                    $check  = null; //date('Y-m-d',strtotime($s_time_01)).' '.date('H:i:00',strtotime($s_time_01));

                    // $check  = BookSession::whereDate('start_time',date('Y-m-d',strtotime($s_time_02)))
                    //                         ->whereTime('start_time',date('H:i:00',strtotime($s_time_02)))
                    //                         ->first();

                    // $check  = BookSession::where('teacher_id',Auth::user()->id)
                    //                         // ->where('end_time','>=',date('Y-m-d H:i:00',strtotime($e_time_02)))
                    //                         // ->where('is_cancelled',0)
                    //                     // ->where( function($qry) use($s_time_02,$e_time_02){
                    //                     //     $qry->whereDate('start_time','>=',date('Y-m-d',strtotime($s_time_02)))
                    //                     //         ->whereTime('start_time','>=',date('H:i:00',strtotime($s_time_02)));
                    //                     // })
                    //                     // ->where( function($qry) use($s_time_02,$e_time_02){
                    //                     //     $qry->whereDate('end_time','>=',date('Y-m-d',strtotime($e_time_02)))
                    //                     //         ->whereTime('end_time','>=',date('H:i:00',strtotime($e_time_02)));
                    //                     // })

                    //                     ->where(function($qry) use($s_time_02,$e_time_02) {
                    //                         $qry->where(function($query) use($s_time_02,$e_time_02) {
                    //                             $query->where('start_time','>=',date('Y-m-d H:i',strtotime($s_time_02)))
                    //                                     ->where('end_time','>=',date('Y-m-d H:i',strtotime($e_time_02)))
                    //                                     ->where('start_time','<=',date('Y-m-d H:i',strtotime($e_time_02)))
                    //                                     ->where('start_time','>=',date('Y-m-d H:i',strtotime($s_time_02)));
                    //                         })
                    //                         ->where(function($query) use($s_time_02,$e_time_02) {
                    //                             $query->where('start_time','<=',date('Y-m-d H:i',strtotime($s_time_02)))
                    //                                     ->where('end_time','<=',date('Y-m-d H:i',strtotime($e_time_02)))
                    //                                     ->where('end_time','>=',date('Y-m-d H:i',strtotime($s_time_02)))
                    //                                     ->where('end_time','<=',date('Y-m-d H:i',strtotime($e_time_02)));
                    //                         })
                    //                         ->orWhere(function($query) use($s_time_02,$e_time_02) {
                    //                             $query->where('start_time','>=',date('Y-m-d H:i',strtotime($s_time_02)))
                    //                                     ->where('end_time','<=',date('Y-m-d H:i',strtotime($e_time_02)));
                    //                         })
                    //                         ->orWhere(function($query) use($s_time_02,$e_time_02) {
                    //                             $query->where('start_time','<=',date('Y-m-d H:i',strtotime($s_time_02)))
                    //                                     ->where('end_time','>=',date('Y-m-d H:i',strtotime($e_time_02)));
                    //                         });
                    //                     })->where('is_cancelled',0)->with('Student')
                    //                     ->first();

                                        
                    $name = $img = '';
                    if($check!=null)
                    {
                        // dd($check->Student->StudentDetail);
                        $name   = $check->Student->name;
                        $img    = ($check->Student!=null && $check->Student->StudentDetail!=null && $check->Student->StudentDetail->avtar!=null)?asset('uploads/user/avatar/'.$check->Student->StudentDetail->avtar):asset('assets/img/user/user.png');
                    }

                    $events[] = array(  'id'        =>'1',
                                        'calendarId'=> 'cal1',
                                        'title'     => ($check!=null)?'Booked':'Available',
                                        'body'      => $cate,
                                        'start'     => $start,
                                        'end'       => $end,
                                        'location'  => 'Meeting Room A',
                                        'attendees' => [($check!=null)?'B':'A', $img , $name],
                                        'category'  => 'time',
                                        'state'     => 'Free',
                                        'color'     => '#fff',
                                        'text01'    => $cate,
                                        'backgroundColor' => ($check!=null)?'gray':'green',
                                    );

                    //Checked Booking

                    // $check  = date('Y-m-d',strtotime($s_time_01)).' '.date('H:i:00',strtotime($s_time_01));
                    
                    if(strtotime($s_time_02)>strtotime($e_time_02))
                    {
                        $e_time_02 = date('Y-m-d h:i: A',strtotime($e_time_02 . ' +1 day'));
                    }
                    date_default_timezone_set('UTC');
                    $check  = BookSession::where('teacher_id',Auth::user()->id)
                                            ->where('start_time','>=',date('Y-m-d H:i:00'))
                                        //     ->where('end_time','>=',date('Y-m-d H:i:00',strtotime($e_time_02)))
                                        //     ->where('is_cancelled',0)
                                        // ->where( function($qry) use($s_time_02,$e_time_02){
                                        //     $qry->whereDate('start_time','>=',date('Y-m-d',strtotime($s_time_02)))
                                        //         ->whereTime('start_time','>=',date('H:i:00',strtotime($s_time_02)));
                                        // })
                                        // ->where( function($qry) use($s_time_02,$e_time_02){
                                        //     $qry->whereDate('end_time','>=',date('Y-m-d',strtotime($e_time_02)))
                                        //         ->whereTime('end_time','>=',date('H:i:00',strtotime($e_time_02)));
                                        // })

                                        ->where(function($qry) use($s_time_02,$e_time_02) {
                                            $qry->where(function($query) use($s_time_02,$e_time_02) {
                                                $query->where('start_time','>=',date('Y-m-d H:i',strtotime($s_time_02)))
                                                        ->where('end_time','>=',date('Y-m-d H:i',strtotime($e_time_02)))
                                                        ->where('start_time','<=',date('Y-m-d H:i',strtotime($e_time_02)))
                                                        ->where('start_time','>=',date('Y-m-d H:i',strtotime($s_time_02)));
                                            })
                                            ->where(function($query) use($s_time_02,$e_time_02) {
                                                $query->where('start_time','<=',date('Y-m-d H:i',strtotime($s_time_02)))
                                                        ->where('end_time','<=',date('Y-m-d H:i',strtotime($e_time_02)))
                                                        ->where('end_time','>=',date('Y-m-d H:i',strtotime($s_time_02)))
                                                        ->where('end_time','<=',date('Y-m-d H:i',strtotime($e_time_02)));
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
                                        ->get();
                    date_default_timezone_set($tz);
                    // dd($check);
                    $name = $img = '';
                    if(count($check))
                    {
                        // dd($check);
                        foreach($check as $check1)
                        {
                            // dd($check->Student->StudentDetail);
                            $name   = ($check1->Student!=null && $check1->Student->name!=null && $check1->Student->name!=null)?$check1->Student->name:'admin';
                            $img    = ($check1->Student!=null && $check1->Student->StudentDetail!=null && $check1->Student->StudentDetail->avtar!=null)?asset('uploads/user/avatar/'.$check1->Student->StudentDetail->avtar):asset('assets/img/user/user.png');

                            $b_time_from   = new \DateTime($check1->start_time, new \DateTimeZone('UTC'));
                            $b_time_to     = new \DateTime($check1->end_time, new \DateTimeZone('UTC'));

                            $b_time_from->setTimezone(new \DateTimeZone($tz));
                            $b_time_to->setTimezone(new \DateTimeZone($tz));

                            $tf_time    = $b_time_from->format("Y-m-d H:i");
                            $tt_time    = $b_time_to->format("Y-m-d H:i");

                            $events[] = array(  'id'        =>($check1!=null)?'2':'1',
                                        'calendarId'=> 'cal1',
                                        'title'     => ($check1!=null)?'Booked':'Available',
                                        'body'      => $cate,
                                        'start'     => str_replace(' ','T',$tf_time),
                                        'end'       => str_replace(' ','T',$tt_time),
                                        'location'  => 'Meeting Room A',
                                        'attendees' => [($check1!=null)?'B':'A', $img , $name],
                                        'category'  => 'time',
                                        'state'     => 'Free',
                                        'color'     => '#fff',
                                        'text01'    => $cate,
                                        'backgroundColor' => ($check1!=null)?'gray':'green',
                                    );
                                    // dd($events);
                        }

                    }


                }

            }

        }

        //Start Find Unavailability
        date_default_timezone_set('UTC');
        $unavailable = Unavailability::where('teacher_id',auth()->user()->id)->where('start_time','>=',date('Y-m-d H:i:00'))->get();
        // dd($unavailable);
        date_default_timezone_set($tz);
        foreach($unavailable as $un)
        {
            $b_time_from   = new \DateTime($un->start_time, new \DateTimeZone('UTC'));
                            $b_time_to     = new \DateTime($un->end_time, new \DateTimeZone('UTC'));

                            $b_time_from->setTimezone(new \DateTimeZone($tz));
                            $b_time_to->setTimezone(new \DateTimeZone($tz));

                            $tf_time    = $b_time_from->format("Y-m-d H:i");
                            $tt_time    = $b_time_to->format("Y-m-d H:i");
            // dd($tf_time,$tt_time);
            $events[] = array(  'id'        =>'2',
                            'calendarId'=> 'cal1',
                            'title'     => 'Unavailable',
                            'body'      => '',
                            'start'     => str_replace(' ','T',$tf_time),
                            'end'       => str_replace(' ','T',$tt_time),
                            'location'  => 'Meeting Room A',
                            'attendees' => ['A', '' , ''],
                            'category'  => 'time',
                            'state'     => 'Free',
                            'color'     => '#fff',
                            'text01'    => '',
                            'backgroundColor' => 'red',
                        );
        }
        //End Find Unavailability

        // dd($events);
        // $events[] = array(  'id'        =>'1',
        //                                 'calendarId'=> 'cal1',
        //                                 'title'     => 'Booked',
        //                                 'body'      => '',
        //                                 'start'     => '2023-07-03T12:30:00',
        //                                 'end'       => '2023-07-03T13:00:00',
        //                                 'location'  => 'Meeting Room A',
        //                                 'attendees' => ['B','',''],
        //                                 'category'  => 'time',
        //                                 'state'     => 'Free',
        //                                 'color'     => '#fff',
        //                                 'text01'    => '',
        //                                 'backgroundColor' => 'red');
        return view('front.teacher.calendar',compact('times1','times2','times3','times4','times5','times6','times7','events','tz','tz1'));
    }

    public function availabilityUpdate(Request $request)
    {
        $day['sun'] = [];
        $day['mon'] = [];
        $day['tue'] = [];
        $day['wed'] = [];
        $day['thu'] = [];
        $day['fri'] = [];
        $day['sat'] = [];

        $arr_set = [];
        $upt_dat = Carbon::now();

        $user    = TeacherSetting::where('user_id',auth()->user()->id)->first();
        $tz      = DB::table('time_zones')->where('id',$user->timezone ?? 136)->first();
        $tz      = $tz->timezone;

        if($request->has('f1') && $request->has('t1') && (count($request->get('f1'))==count($request->get('t1'))))
        {
            for($i=0;$i<=count($request->get('f1'))-1;$i++)
            {
                // $day['sun'][] = $request->get('f1')[$i].'-'.$request->get('t1')[$i];
                $time_from  = date('Y-m-d').' '.$request->get('f1')[$i];
                $time_to    = date('Y-m-d').' '.$request->get('t1')[$i];

                $time_from_t1   = new \DateTime($time_from, new \DateTimeZone($tz));
                $time_to_t1     = new \DateTime($time_to, new \DateTimeZone($tz));

                $time_from_t1->setTimezone(new \DateTimeZone("UTC"));
                $time_to_t1->setTimezone(new \DateTimeZone("UTC"));

                $tf_time    = $time_from_t1->format("h:i A");
                $tt_time    = $time_to_t1->format("h:i A");

                // echo $given->format("Y-m-d h:i:s A").'<br>';
                // $given->setTimezone(new \DateTimeZone("UTC"));
                // echo $given->format("Y-m-d h:i:s A").'<br>';
                // dd($request->get('f1')[$i].'-'.$request->get('t1')[$i]);
                // 'time_from'=>$request->get('f1')[$i],'time_to'=>$request->get('t1')[$i]

                $arr_set[]  = array('user_id'=>Auth::user()->id,'day'=>'sun','time_from'=>$tf_time,'time_to'=>$tt_time,'updated_at'=>$upt_dat);
            }
        }
        if($request->has('f2') && $request->has('t2') && (count($request->get('f2'))==count($request->get('t2'))))
        {
            for($i=0;$i<=count($request->get('f2'))-1;$i++)
            {
                // $day['mon'][] = $request->get('f2')[$i].'-'.$request->get('t2')[$i];
                $time_from  = date('Y-m-d').' '.$request->get('f2')[$i];
                $time_to    = date('Y-m-d').' '.$request->get('t2')[$i];

                $time_from_t1   = new \DateTime($time_from, new \DateTimeZone($tz));
                $time_to_t1     = new \DateTime($time_to, new \DateTimeZone($tz));

                $time_from_t1->setTimezone(new \DateTimeZone("UTC"));
                $time_to_t1->setTimezone(new \DateTimeZone("UTC"));

                $tf_time    = $time_from_t1->format("h:i A");
                $tt_time    = $time_to_t1->format("h:i A");
                $arr_set[] = array('user_id'=>Auth::user()->id,'day'=>'mon','time_from'=>$tf_time,'time_to'=>$tt_time,'updated_at'=>$upt_dat);
            }
        }
        if($request->has('f3') && $request->has('t3') && (count($request->get('f3'))==count($request->get('t3'))))
        {
            for($i=0;$i<=count($request->get('f3'))-1;$i++)
            {
                // $day['tue'][] = $request->get('f3')[$i].'-'.$request->get('t3')[$i];
                $time_from  = date('Y-m-d').' '.$request->get('f3')[$i];
                $time_to    = date('Y-m-d').' '.$request->get('t3')[$i];

                $time_from_t1   = new \DateTime($time_from, new \DateTimeZone($tz));
                $time_to_t1     = new \DateTime($time_to, new \DateTimeZone($tz));

                $time_from_t1->setTimezone(new \DateTimeZone("UTC"));
                $time_to_t1->setTimezone(new \DateTimeZone("UTC"));
                
                $tf_time    = $time_from_t1->format("h:i A");
                $tt_time    = $time_to_t1->format("h:i A");
                $arr_set[] = array('user_id'=>Auth::user()->id,'day'=>'tue','time_from'=>$tf_time,'time_to'=>$tt_time,'updated_at'=>$upt_dat);
            }
        }
        if($request->has('f4') && $request->has('t4') && (count($request->get('f4'))==count($request->get('t4'))))
        {
            for($i=0;$i<=count($request->get('f4'))-1;$i++)
            {
                // $day['wed'][] = $request->get('f4')[$i].'-'.$request->get('t4')[$i];
                $time_from  = date('Y-m-d').' '.$request->get('f4')[$i];
                $time_to    = date('Y-m-d').' '.$request->get('t4')[$i];

                $time_from_t1   = new \DateTime($time_from, new \DateTimeZone($tz));
                $time_to_t1     = new \DateTime($time_to, new \DateTimeZone($tz));

                $time_from_t1->setTimezone(new \DateTimeZone("UTC"));
                $time_to_t1->setTimezone(new \DateTimeZone("UTC"));

                $tf_time    = $time_from_t1->format("h:i A");
                $tt_time    = $time_to_t1->format("h:i A");
                $arr_set[] = array('user_id'=>Auth::user()->id,'day'=>'wed','time_from'=>$tf_time,'time_to'=>$tt_time,'updated_at'=>$upt_dat);
            }
        }
        if($request->has('f5') && $request->has('t5') && (count($request->get('f5'))==count($request->get('t5'))))
        {
            for($i=0;$i<=count($request->get('f5'))-1;$i++)
            {
                // $day['thu'][] = $request->get('f5')[$i].'-'.$request->get('t5')[$i];
                $time_from  = date('Y-m-d').' '.$request->get('f5')[$i];
                $time_to    = date('Y-m-d').' '.$request->get('t5')[$i];

                $time_from_t1   = new \DateTime($time_from, new \DateTimeZone($tz));
                $time_to_t1     = new \DateTime($time_to, new \DateTimeZone($tz));

                $time_from_t1->setTimezone(new \DateTimeZone("UTC"));
                $time_to_t1->setTimezone(new \DateTimeZone("UTC"));

                $tf_time    = $time_from_t1->format("h:i A");
                $tt_time    = $time_to_t1->format("h:i A");
                $arr_set[] = array('user_id'=>Auth::user()->id,'day'=>'thu','time_from'=>$tf_time,'time_to'=>$tt_time,'updated_at'=>$upt_dat);
            }
        }
        if($request->has('f6') && $request->has('t6') && (count($request->get('f6'))==count($request->get('t6'))))
        {
            for($i=0;$i<=count($request->get('f6'))-1;$i++)
            {
                // $day['fri'][] = $request->get('f6')[$i].'-'.$request->get('t6')[$i];
                $time_from  = date('Y-m-d').' '.$request->get('f6')[$i];
                $time_to    = date('Y-m-d').' '.$request->get('t6')[$i];

                $time_from_t1   = new \DateTime($time_from, new \DateTimeZone($tz));
                $time_to_t1     = new \DateTime($time_to, new \DateTimeZone($tz));

                $time_from_t1->setTimezone(new \DateTimeZone("UTC"));
                $time_to_t1->setTimezone(new \DateTimeZone("UTC"));

                $tf_time    = $time_from_t1->format("h:i A");
                $tt_time    = $time_to_t1->format("h:i A");
                $arr_set[] = array('user_id'=>Auth::user()->id,'day'=>'fri','time_from'=>$tf_time,'time_to'=>$tt_time,'updated_at'=>$upt_dat);
            }
        }
        if($request->has('f7') && $request->has('t7') && (count($request->get('f7'))==count($request->get('t7'))))
        {
            for($i=0;$i<=count($request->get('f7'))-1;$i++)
            {
                // $day['sat'][] = $request->get('f7')[$i].'-'.$request->get('t7')[$i];
                $time_from  = date('Y-m-d').' '.$request->get('f7')[$i];
                $time_to    = date('Y-m-d').' '.$request->get('t7')[$i];

                $time_from_t1   = new \DateTime($time_from, new \DateTimeZone($tz));
                $time_to_t1     = new \DateTime($time_to, new \DateTimeZone($tz));

                $time_from_t1->setTimezone(new \DateTimeZone("UTC"));
                $time_to_t1->setTimezone(new \DateTimeZone("UTC"));

                $tf_time    = $time_from_t1->format("h:i A");
                $tt_time    = $time_to_t1->format("h:i A");
                $arr_set[] = array('user_id'=>Auth::user()->id,'day'=>'sat','time_from'=>$tf_time,'time_to'=>$tt_time,'updated_at'=>$upt_dat);
            }
        }

        // $update = Availability::updateOrCreate(['user_id'=>Auth::user()->id],['times'=>json_encode($day),'updated_at'=>Carbon::now()]);
        // dd($arr_set);
        DB::beginTransaction();

        try{
            $delete = Availability::where('user_id',Auth::user()->id)->delete();
            $update = Availability::insert($arr_set);

            DB::commit();
            return redirect()->back()->with('success','Availability has been updated successfully');
        }catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage());
            return redirect()->back()->with('error','Oops something went wrong');
        }




    }

    public function timezone(Request $request)
    {
        $user_id = Auth::user()->id;
        $rules = [
            'country' => 'required',
            'timezone' => 'required',
        ];
        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validation->errors()
            ]);

        }
        DB::beginTransaction();
        try{

            $data1 = [
                'user_id' => $user_id,
                'country' => $request->input('country'),
                'timezone' => $request->input('timezone'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $check = TeacherSetting::where('user_id',$user_id)->first();
            if($check !=Null){
                TeacherSetting::where('user_id',$user_id)->update($data1);
            }else{
                TeacherSetting::insert($data1);
            }

            DB::commit();
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
            $student = DB::table('users')->where('id',$book_session->student_id)->first();
            $pricing = DB::table('pricings')->where('id',$book_session->class_id)->first();
            $price_master = DB::table('price_masters')->where('id',$pricing->price_master)->first();
            $class_name = $price_master->title.' - '.$pricing->totle_class.'x classes - '.$pricing->time.'min';
            $date = $book_session->start_time->format('Y-m-d');
            //teacher time zone according to member
            $t_timezone = DB::table('student_details')->where('user_id',$book_session->student_id)->first();
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

            $price1 = DB::table('credits')->where('user_id',$book_session->student_id)->where('class_id',$book_session->class_id)->first();

            $data1 = [
                'credit' => $price1->credit + 1,
            ];
            DB::table('credits')->where('user_id',$book_session->student_id)->where('class_id',$book_session->class_id)->update($data1);

            $email2 =
            [
            'sender_email' => $student->email,
            'inext_email' => env('MAIL_USERNAME'),
            's_name' => $student->name,
            'title' => 'Class cancelled!',
            'class_name' => $class_name,
            'class_time' => $time,
            'class_date' => $date
            ];

            Mail::send('email.teacher-cancle', $email2, function ($messages) use ($email2) {
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

    public function unavailability(Request $request){
        $request->validate([
            'date'      => 'required|date|after:now',
            'time_from' => 'required|date_format:H:i',
            'time_to'   => 'required|date_format:H:i|after:time_from', //after_or_equal
        ]);

        $user_id= auth()->user()->id;
        $user   = TeacherSetting::where('user_id',$user_id)->first();
        $tz     = DB::table('time_zones')->where('id',$user->timezone ?? 136)->first();
        $tz     = $tz->timezone;

        $date_time      = $request->date.'T'.$request->time_from; //str_replace('T',' ',  $request->time_from);
        $time_from_t1   = new \DateTime($date_time, new \DateTimeZone($tz));
        $time_from_t1->setTimezone(new \DateTimeZone('UTC'));
        $start_time = $time_from_t1->format("Y-m-d H:i:s");

        $date_time      = $request->date.'T'.$request->time_to; //str_replace('T',' ',  $request->time_to);
        $time_from_t1   = new \DateTime($date_time, new \DateTimeZone($tz));
        $time_from_t1->setTimezone(new \DateTimeZone('UTC'));
        $end_time = $time_from_t1->format("Y-m-d H:i:s");

        // dd($start_time,$end_time);
        $insert = Unavailability::insert(['teacher_id'=>$user_id,'start_time'=>$start_time,'end_time'=>$end_time,'created_at'=>date('Y-m-d H:i:s')]);
        if($insert)
        {
            $res = array('status'=>true,'msg'=>'Unavailability Set Successfully');
        }
        else{
            $res = array('status'=>false,'msg'=>'Oops Something Went Wrong');
        }

        return json_encode($res);
        // dd($request->all());
    }
    public function cancleunavailability(Request $request)
    {
        if($request->ajax())
        {
            
            $user = DB::table('unavailabilities')->where('teacher_id',Auth::user()->id)->get();
            
            $datatables = Datatables::of($user)
            ->editColumn('check', function ($row) {
                return '<span class="form-check mb-0"><input type="checkbox" id="chk_sel_"><label class="form-check-label" for="chk_sel_"></label></span>';
            })
            ->editColumn('created_at', function ($row) {
                return date('d M, Y',strtotime($row->created_at));
            })
            ->addColumn('action', function($row) {
                $action_3 = '<a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover deleteBtn"
                                data-bs-toggle="tooltip" data-placement="top" title=""
                                data-bs-original-title="Delete" href="javascript:void(0)" data-id="'.base64_encode($row->id).'">
                                <span class="icon">
                                    <span class="feather-icon">
                                    <i class="fas fa-trash text-danger"></i>
                                    </span>
                                </span>
                            </a>';



                $action = '<div class="d-flex align-items-center">
                                <div class="d-flex">
                                    '.$action_3.'
                                </div>
                            </div>';
                return $action;
            });

            $datatables = $datatables->rawColumns(['check', 'action'])->make(true);

            return $datatables;
        }

        return view('front.teacher.calendar');
    }
}
