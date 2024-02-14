<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\Rule;
use App\Models\Availability;
use App\Models\TeacherSetting;
use Mail;
use Carbon\Carbon;
use App\Models\BookSession;
use App\Models\Credit;
use App\Models\Pricing;
use App\Models\Unavailability;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
            if($request->ajax())
            {
                $user = DB::table('users')->where('user_type',2)->where('status','<>',2)->OrderBy('created_at','DESC')->get();

                $datatables = Datatables::of($user)
                ->editColumn('check', function ($row) {
                    return '<span class="form-check mb-0"><input type="checkbox" id="chk_sel_"><label class="form-check-label" for="chk_sel_"></label></span>';
                })
                ->editColumn('created_at', function ($row) {
                    return date('d M, Y',strtotime($row->created_at));
                })
                ->addColumn('action', function($row) {
                    $action_1 = '';
                    if($row->status==0)
                    {
                        $action_1 = '<a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover statusBtn"
                                            data-bs-toggle="tooltip" data-placement="top" title=""
                                            data-bs-original-title="Inactive" href="#" data-dc="'.base64_encode($row->id).'" data-id="'.base64_encode($row->id).'" data-type="'.base64_encode('enable').'">
                                            <span class="icon">
                                            <i class="fas fa-circle-dot" style="color:red;"></i>
                                            </span>
                                        </a>
                                        <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover statusBtn d-none"
                                            data-bs-toggle="tooltip" data-placement="top" title=""
                                            data-bs-original-title="Active" href="#" data-ac="'.base64_encode($row->id).'" data-id="'.base64_encode($row->id).'" data-type="'.base64_encode('disable').'">
                                            <span class="icon">
                                            <i class="fas fa-circle-dot" style="color:green;"></i>
                                            </span>
                                        </a>';
                    }
                    else
                    {
                        $action_1 = '<a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover statusBtn d-none"
                                            data-bs-toggle="tooltip" data-placement="top" title=""
                                            data-bs-original-title="Inactive" href="#" data-dc="'.base64_encode($row->id).'" data-id="'.base64_encode($row->id).'" data-type="'.base64_encode('enable').'">
                                            <span class="icon">
                                            <i class="fas fa-circle-dot" style="color:red;"></i>
                                            </span>
                                        </a>
                                        <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover statusBtn"
                                            data-bs-toggle="tooltip" data-placement="top" title=""
                                            data-bs-original-title="Active" href="#" data-ac="'.base64_encode($row->id).'" data-id="'.base64_encode($row->id).'" data-type="'.base64_encode('disable').'">
                                            <span class="icon">
                                            <i class="fas fa-circle-dot" style="color:green;"></i>
                                            </span>
                                        </a>';
                    }

                    $edit_url = url('/admin/teacher/edit',['id'=>base64_encode($row->id)]);

                    $action_2 = '<a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"
                                    data-bs-toggle="tooltip" data-placement="top" title=""
                                    data-bs-original-title="Edit" href="'.$edit_url.'">
                                    <span class="icon">
                                        <span class="feather-icon">
                                        <i class="fas fa-edit text-info"></i>
                                        </span>
                                    </span>
                                </a>';

                    $action_3 = '<a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover deleteBtn"
                                    data-bs-toggle="tooltip" data-placement="top" title=""
                                    data-bs-original-title="Delete" href="javascript:void(0)" data-id="'.base64_encode($row->id).'">
                                    <span class="icon">
                                        <span class="feather-icon">
                                        <i class="fas fa-trash text-danger"></i>
                                        </span>
                                    </span>
                                </a>';

                    $cal = url('/admin/calendar',['id'=>base64_encode($row->id)]);

                    $action_4 = '<a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"
                                data-bs-toggle="tooltip" data-placement="top" title=""
                                data-bs-original-title="Edit" href="'.$cal.'">
                                <span class="icon">
                                    <span class="feather-icon">
                                    <i class="fa fa-calendar-days text-danger"></i>
                                    </span>
                                </span>
                            </a>';



                    $action = '<div class="d-flex align-items-center">
                                    <div class="d-flex">
                                        '.$action_1.'
                                        '.$action_2.'
                                        '.$action_3.'
                                        '.$action_4.'
                                    </div>
                                </div>';
                    return $action;
                });

                $datatables = $datatables->rawColumns(['check','created_at','action'])->make(true);

                return $datatables;
            }

            return view('admin.teacher.index');
    }

    public function create(Request $request)
    {
        if($request->isMethod('get'))
        {
            return view('admin.teacher.create');
        }

        $rules = [
            'name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'email' => ['required','email:rfc,dns',Rule::unique('users')->where(fn ($query) => $query->where('status','<>', 2))],
            'phone' => 'required|regex:/^[0-9]+$/|min:5|unique:users',
            'resume' => 'required',
            'password' => 'required|min:5',
            'message' => 'required',
        ];

        $custom = [
            'email.unique'  =>'Email id has already been taken',
            'phone.regex' => 'Phone Number Must be Numeric',

        ];

        $validation = Validator::make($request->all(), $rules,$custom);

        if ($validation->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validation->errors()
            ]);

        }

        DB::beginTransaction();
        try{

            // $randomPassword = $request->input('password');

            // if (!preg_match("/^(?=.{10,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[$@%£!]).*$/", $randomPassword)){

            //         return response()->json([
            //             'success' => false,
            //             'custom'=>'yes',
            //             'errors' => ['password'=>'Password must be atleast 10 characters long including (Atleast 1 uppercase letter(A–Z), Lowercase letter(a–z), 1 number(0–9), 1 non-alphanumeric symbol(‘$%£!’) !']
            //         ]);
            // }
            $hashed_random_password = Hash::make($request->input('password'));

                if($request->file('resume')){

                    $image = $request->file('resume');
                    $date = date('YmdHis');
                    $no = str_shuffle('123456789023456789034567890456789905678906789078908909000987654321987654321876543217654321654321543214321321211');
                    $random_no = substr($no, 0, 2);
                    $final_image_name = $date.$random_no.'.'.$image->getClientOriginalExtension();

                    $destination_path = public_path('/upload/resume/');
                    if(!File::exists($destination_path))
                    {
                        File::makeDirectory($destination_path, $mode = 0777, true, true);
                    }
                    $image->move($destination_path , $final_image_name);

            }
            $data = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'resume' =>  !empty($final_image_name) ? $final_image_name:NULL,
                'password' => $hashed_random_password,
                'plan_password' => $request->input('password'),
                'message' => $request->input('message'),
                'user_type' =>2,
                'term' => 1,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $email =
            [
            'sender_email' => $request->email,
            'inext_email' => env('MAIL_USERNAME'),
            'sender_name' => $request->name,
            'title' => 'Successfully Registered!',
            ];

            Mail::send('email.when-teacher-register-they-will-get-email', $email, function ($messages) use ($email) {
                $messages->to($email['sender_email'])
                ->from($email['inext_email'], 'Latogo');
                $messages->subject("Welcome to Latogo - Let's Begin Your German Language Journey!");
            });


            DB::table('users')->insert($data);

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
    public function edit(Request $request)
    {
        $customer_id = base64_decode($request->id);

        if($request->isMethod('get'))
        {
            $teacher = DB::table('users')->where('user_type',2)->where('id',$customer_id)->first();

            return view('admin.teacher.edit',compact('teacher'));
        }

        $rules = [
            'name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'email' => 'required',
            'phone' => 'required|regex:/^[0-9]+$/|min:5',
            'password' => 'required|min:5',
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validation->errors()
            ]);

        }

        $about = DB::table('users')->where('id',$customer_id)->first();

        DB::beginTransaction();
        try{
                if($request->file('resume')){

                    $image = $request->file('resume');
                    $date = date('YmdHis');
                    $no = str_shuffle('123456789023456789034567890456789905678906789078908909000987654321987654321876543217654321654321543214321321211');
                    $random_no = substr($no, 0, 2);
                    $final_image_name = $date.$random_no.'.'.$image->getClientOriginalExtension();

                    $destination_path = public_path('/upload/resume/');
                    if(!File::exists($destination_path))
                    {
                        File::makeDirectory($destination_path, $mode = 0777, true, true);
                    }
                    $image->move($destination_path , $final_image_name);

            }
            else
            {
                $final_image_name = $about->resume;
            }

            if($request->input('password')){

                $hashed_random_password = Hash::make($request->input('password'));

            }
            else
            {
                $hashed_random_password = $about->password;
                $plan_password = $about->plan_password;
            }

            $data = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'resume' => !empty($final_image_name) ? $final_image_name:NULL,
                'message' => $request->input('message'),
                'password' => !empty($hashed_random_password) ? $hashed_random_password:NULL,
                'plan_password' => $request->input('password') ?? $plan_password,
                'term' => 1,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            DB::table('users')->where('id',$customer_id)->update($data);

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
    public function calendar(Request $request)
    {
        $user_id = base64_decode($request->id);
        $day['sun'] = [];
        $day['mon'] = [];
        $day['tue'] = [];
        $day['wed'] = [];
        $day['thu'] = [];
        $day['fri'] = [];
        $day['sat'] = [];
        $events     = [];

        // $user   = TeacherSetting::where('user_id',auth()->user()->id)->first();
        $user   = TeacherSetting::where('user_id',$user_id)->first();
        $tz     = DB::table('time_zones')->where('id',$user->timezone ?? 136)->first();
        $tz1    = $tz->raw_offset;
        $tz     = $tz->timezone;
        date_default_timezone_set($tz);

        $times1 = Availability::where(['user_id'=>$user_id,'day'=>'sun'])->get();
        $times2 = Availability::where(['user_id'=>$user_id,'day'=>'mon'])->get();
        $times3 = Availability::where(['user_id'=>$user_id,'day'=>'tue'])->get();
        $times4 = Availability::where(['user_id'=>$user_id,'day'=>'wed'])->get();
        $times5 = Availability::where(['user_id'=>$user_id,'day'=>'thu'])->get();
        $times6 = Availability::where(['user_id'=>$user_id,'day'=>'fri'])->get();
        $times7 = Availability::where(['user_id'=>$user_id,'day'=>'sat'])->get();

        $teacher_av = Availability::where('user_id',$user_id)->get();

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

                    $start  = date('Y-m-d',strtotime($s_time_01)).'T'.date('H:i:00',strtotime($s_time_01));
                    $cate   = date('d M Y',strtotime($s_time_01)).' at '.date('h:i A',strtotime($s_time_01));
                    $end    = date('Y-m-d',strtotime($e_time_01)).'T'.date('H:i:00',strtotime($e_time_01));

                    $check  = null; //date('Y-m-d',strtotime($s_time_01)).' '.date('H:i:00',strtotime($s_time_01));

                    // $check  = BookSession::whereDate('start_time',date('Y-m-d',strtotime($s_time_02)))
                    //                         ->whereTime('start_time',date('H:i:00',strtotime($s_time_02)))
                    //                         ->first();
                    $name = $img = '';
                    if($check!=null)
                    {
                        // dd($check->Student->StudentDetail);
                        $name   = $check->Student->name ?? null;
                        $img    = ($check->Student!=null && $check->Student->StudentDetail!=null && $check->Student->StudentDetail->avtar!=null)?asset('uploads/user/avatar/'.$check->Student->StudentDetail->avtar):asset('assets/img/user/user.png');
                    }

                    $events[] = array(  'id'        =>($check!=null)?'2':'1',
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
                    // dd($s_time_02,$e_time_02);

                    // $check  = BookSession::where( function($qry) use($s_time_02,$e_time_02){
                    //                         $qry->whereDate('start_time','>=',date('Y-m-d',strtotime($s_time_02)))
                    //                             ->whereTime('start_time','>=',date('H:i:00',strtotime($s_time_02)));
                    //                     })
                    //                     ->where( function($qry) use($s_time_02,$e_time_02){
                    //                         $qry->whereDate('end_time','>=',date('Y-m-d',strtotime($e_time_02)))
                    //                             ->whereTime('end_time','>=',date('H:i:00',strtotime($e_time_02)));
                    //                     })
                    //                     ->where('is_cancelled',0)
                    //                     ->get();

                    if(strtotime($s_time_02)>strtotime($e_time_02))
                    {
                        $e_time_02 = date('Y-m-d h:i: A',strtotime($e_time_02 . ' +1 day'));
                    }
                    date_default_timezone_set('UTC');
                    $check  = BookSession::where('teacher_id',$user_id)
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
                                        ->where('student_url','<>',null)
                                        ->get();
                    date_default_timezone_set($tz);


                    $name = $img = '';
                    if(count($check))
                    {
                        // dd($check);
                        foreach($check as $check1)
                        {
                            if(isset($check1->Student) && $check1->Student->name != null){
                            // dd($check1);
                            // dd($check->Student->StudentDetail);
                            $name   = $check1->Student->name;
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

        }

        //Find Unavailability
        date_default_timezone_set('UTC');
        $unavailable = Unavailability::where('teacher_id',$user_id)->where('start_time','>=',date('Y-m-d H:i:00'))->get();
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
        $student_data = DB::table('users')->where('user_type',1)->where('status',1)->get();
        // dd($events);

        return view('admin.teacher.calendar',compact('times1','times2','times3','times4','times5','times6','times7','events','tz','tz1','user_id','student_data'));
    }

    public function availabilityUpdate(Request $request)
    {
        $user_id = $request->user_id;
        $day['sun'] = [];
        $day['mon'] = [];
        $day['tue'] = [];
        $day['wed'] = [];
        $day['thu'] = [];
        $day['fri'] = [];
        $day['sat'] = [];

        $arr_set = [];
        $upt_dat = Carbon::now();

        $user    = TeacherSetting::where('user_id',$user_id)->first();
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

                $arr_set[]  = array('user_id'=>$user_id,'day'=>'sun','time_from'=>$tf_time,'time_to'=>$tt_time,'updated_at'=>$upt_dat);
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
                $arr_set[] = array('user_id'=>$user_id,'day'=>'mon','time_from'=>$tf_time,'time_to'=>$tt_time,'updated_at'=>$upt_dat);
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
                $arr_set[] = array('user_id'=>$user_id,'day'=>'tue','time_from'=>$tf_time,'time_to'=>$tt_time,'updated_at'=>$upt_dat);
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
                $arr_set[] = array('user_id'=>$user_id,'day'=>'wed','time_from'=>$tf_time,'time_to'=>$tt_time,'updated_at'=>$upt_dat);
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
                $arr_set[] = array('user_id'=>$user_id,'day'=>'thu','time_from'=>$tf_time,'time_to'=>$tt_time,'updated_at'=>$upt_dat);
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
                $arr_set[] = array('user_id'=>$user_id,'day'=>'fri','time_from'=>$tf_time,'time_to'=>$tt_time,'updated_at'=>$upt_dat);
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
                $arr_set[] = array('user_id'=>$user_id,'day'=>'sat','time_from'=>$tf_time,'time_to'=>$tt_time,'updated_at'=>$upt_dat);
            }
        }

        // $update = Availability::updateOrCreate(['user_id'=>$user_id],['times'=>json_encode($day),'updated_at'=>Carbon::now()]);
        // dd($arr_set);
        DB::beginTransaction();

        try{
            $delete = Availability::where('user_id',$user_id)->delete();
            $update = Availability::insert($arr_set);

            DB::commit();
            return redirect()->back()->with('success','Availability has been updated successfully');
        }catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage());
            return redirect()->back()->with('error','Oops something went wrong');
        }
    }
    public function st_time(Request $request)
    {
        $id = $request->std;
        $cred11 = Credit::where('user_id',$id)->sum('credit');
        if($cred11 > 0){
            $price = Credit::where('user_id',$id)->select('class_id')->get();
            $p1 = $price->toArray();
            $std = array_values($p1);
            $price = DB::table('pricings')->whereIn('id',$std)->get();
            $data = [];
            foreach($price as $pri){
                $pri1 = DB::table('price_masters')->where('id',$pri->price_master)->first();
                $pri2 = DB::table('credits')->where('class_id',$pri->id)->where('user_id',$id)->first();
                if($pri2->credit > 0)
                {
                    $data []= [
                        'id' => $pri->id,
                        'title' => $pri1->title,
                        'class' => $pri->totle_class,
                        'time' => $pri->time,
                    ];
                }
            }
            return response()->json([
             'st_id' => $id,
             'data' => $data,
             'success' =>true
         ]);
        }else{
            return response()->json([
                'success' =>false
            ]);
        }
    }
    public function cal_data(Request $request)
    {
        // date_default_ timezone_set("Europe/Paris");
        $class_id = $request->c_id;

        $credit_value = Credit::where(['user_id'=>$request->s_id,'class_id'=>$request->c_id])->first();
        $credit = $credit_value->credit;
        // dd($credit);
        $t_timezone = DB::table('teacher_settings')->where('user_id',$request->t_id)->first();
        $timezone = DB::table('time_zones')->where('id',$t_timezone->timezone)->first();

        $tz = $timezone->timezone ?? 'Europe/Berlin';
        $tz1 = $timezone->raw_offset ?? '1.00';
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
 
                    // if($timeCom < $timeCom2)
                    // {
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
                                        })
                                        ->first();
                        // dd($check,$unavailable);
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

                    // }

                }
            }

        }

        //Find Unavailability
        // date_default_timezone_set('UTC');
        // $unavailable = Unavailability::where('teacher_id',$request->t_id)->where('start_time','>=',date('Y-m-d H:i:00'))->get();
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

        $html = view('admin.teacher.cal',compact('events','tz','tz1'))->render();
        return json_encode(['status'=>true,'html'=>$html , 'class_id'=>$class_id, 'credit'=>$credit]);
    }

    public function book_session(Request $req){

        // dd($req->all());
        $date_time1 = explode(',',$req->date_time);
        for($i=0; $i < count($date_time1); $i++){
            
            $t_timezone = DB::table('teacher_settings')->where('user_id',$req->teacher_id)->first();
            $timezone = null;
            if($t_timezone!=null)
            {
                $timezone = DB::table('time_zones')->where('id',$t_timezone->timezone)->first();
            }
            $tz = $timezone->timezone ?? 'Europe/Berlin';
            $tz1 = $timezone->raw_offset ?? '1.00';

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
                                    'start_time'    => $start_time,
                                    'end_time'      => $end_time,
                                    'duration'      => $interval,
                                    'created_at'    => Carbon::now()
                                );
            // dd($insert_arr);

            $insert_id  = BookSession::create($insert_arr)->id;
            
            if($insert_id!=null)
            {
                $this->merithub_create_class1($insert_id);
            }
            else{
                return json_encode(['status'=>false,'msg'=>'Oops something went wrong','url'=>'']);
            }
        }
        return json_encode(['status'=>true,'msg'=>'Booking Successfull']);

    }
    public function merithub_create_class1($book_id)
    {
        // dd($request->id);
        $check = BookSession::find($book_id);
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
                    }

                    if(empty($s_user->mh_user_id))
                    {
                        $url2   = "https://serviceaccount1.meritgraph.com/v1/".$merithub->client_id."/users";

                        $data2  = array("name"=>($s_user->name==null || $s_user->name=='')?$s_user->email:$s_user->name,
                                        "img"=>$student_img,
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
                        // dd($result2);
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
                    Credit::where(['user_id'=>$check->student_id,'class_id'=>$check->class_id])->decrement('credit',1);

                    // Update book Session
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
                    return redirect()->route('admin.teacher')->with('success','Class created successfully.');

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
            return redirect()->route('admin.teacher')->with('error','Oops something went wrong');
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
                    }

                    if(empty($s_user->mh_user_id))
                    {
                        $url2   = "https://serviceaccount1.meritgraph.com/v1/".$merithub->client_id."/users";

                        $data2  = array("name"=>($s_user->name==null || $s_user->name=='')?$s_user->email:$s_user->name,
                                        "img"=>$student_img,
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
                        // dd($result2);
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
                    Credit::where(['user_id'=>$check->student_id,'class_id'=>$check->class_id])->decrement('credit',1);

                    // Update book Session
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
                    return redirect()->route('admin.teacher')->with('success','Class created successfully.');

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
            return redirect()->route('admin.teacher')->with('error','Oops something went wrong');
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
}
