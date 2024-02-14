<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Models\Order;
use App\Models\BookSession;
use Illuminate\Validation\Rule;
use Mail;

class StudentSettingController extends Controller
{

    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        $student = DB::table('users')->where('id',$user_id)->where('status',1)->first();
        $student1 = DB::table('student_details')->where('user_id',$user_id)->first();
        $timezone = DB::table('states')->where('country_id',$student1->country)->get();
        $country = DB::table('countries')->get();
        return view('front.student-settings',compact('student','country','student1','timezone'));
    }
    public function create(Request $request)
    {

        if($request->isMethod('get'))
        {
            $user_id = Auth::user()->id;
            $student = DB::table('users')->where('id',$user_id)->where('status',1)->first();
            $country = DB::table('countries')->get();
            return view('front.student-settings',compact('student'));
        }

        $user_id = Auth::user()->id;
        $rules = [
            'first_name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'phone' => 'required',
            'address' => 'required',
            'country' => 'required',
            'timezone' => 'required',
            'postal_code' => 'required',
        ];
        $custom = [
            'timezone.required' => 'The state field is required'
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

            $student_data = DB::table('student_details')->where('user_id',$user_id)->first();
            if($request->file('avtar')){

                $image = $request->file('avtar');
                $date = date('YmdHis');
                $no = str_shuffle('123456789023456789034567890456789905678906789078908909000987654321987654321876543217654321654321543214321321211');
                $random_no = substr($no, 0, 2);
                $final_image_name = $date.$random_no.'.'.$image->getClientOriginalExtension();

                $destination_path = public_path('uploads/user/avatar/');
                if(!File::exists($destination_path))
                {
                    File::makeDirectory($destination_path, $mode = 0777, true, true);
                }
                $image->move($destination_path , $final_image_name);

            }
            else
            {
                $final_image_name = $student_data->avtar ?? '';
            }

            $name = trim(preg_replace('/^\s+|\s+$|\s+(?=\s)/', '', $request->input('first_name').' '.$request->input('last_name')));

            $data = [
                'name' => $name,
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $data1 = [
                'user_id' => $user_id,
                'address1' => $request->input('address'),
                'avtar' => !empty($final_image_name) ? $final_image_name:NULL,
                'country' => $request->input('country'),
                'state' => $request->input('timezone'),
                'postal_code' => $request->input('postal_code'),
                'time_formate' => $request->timeformat,
                'created_at' => date('Y-m-d H:i:s')
            ];
            DB::table('users')->where('id',$user_id)->update($data);
            $student_data = DB::table('student_details')->where('user_id',$user_id)->first();
            if($student_data !=Null){
                DB::table('student_details')->where('user_id',$user_id)->update($data1);
            }else{
                DB::table('student_details')->insert($data1);
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
    public function class(Request $request)
    {
        // echo date('Y-m-d H:i:s') . "<br>\n";
        // date_default_timezone_set('UTC');
        // echo date('Y-m-d H:i:s', time()) . "<br>\n";
        // die;
        $tz = Auth::user()->load('StudentDetail.TimeZone');
        $tz = ($tz->StudentDetail != null && $tz->StudentDetail->TimeZone!=null)?$tz->StudentDetail->TimeZone->timezone:'Europe/Berlin';

        $date = new \DateTime();
        $date->setTimezone(new \DateTimeZone('UTC')); //$tz
        $cur_date = $date->format('Y-m-d H:i:s');
        // dd($cur_date);
        if($request->ajax() && $request->has('date') && $request->get('date')!=''){

            $time_con01 = date('Y-m-d',strtotime($request->get('date'))); //date('Y-m-d H:i',strtotime($request->get('date').' '.date('H:i')));
            $time_con02 = new \DateTime($time_con01, new \DateTimeZone($tz));
            $time_con02->setTimezone(new \DateTimeZone('UTC'));
            $time_con03 = $time_con02->format("Y-m-d"); //format("Y-m-d H:i");
            // dd($time_con01,$time_con03);
            // DB::enableQueryLog();
            $upcommit = BookSession::where(['student_id'=>auth()->user()->id])
                    // ->whereDate('end_time', '>', $cur_date)
                    // ->whereDate('end_time', '=', $time_con03)
                    ->whereDate('student_date',$time_con01)
                    ->orderBy('start_time','ASC')
                    ->get();
            $upcommit1 = BookSession::where(['student_id'=>auth()->user()->id])
            // ->whereDate('end_time', '>', $cur_date)
            // ->whereDate('end_time', '=', $time_con03)
            ->whereDate('student_date',$time_con01)
            ->where('is_cancelled',0)
            ->orderBy('start_time','ASC')
            ->get();
            // dd(DB::getQueryLog());
            $html = view('front.student-upcomming-ajax',compact('upcommit','upcommit1','tz'))->render();
            $data = array('status'=>true,'html'=>$html);

            return json_encode($data);
        }



        $upcommit = BookSession::where('student_id',auth()->user()->id)
                    ->where('end_time','>=',$cur_date)
                    ->orderBy('start_time','ASC')
                    ->get();
        $upcommit1 = BookSession::where('student_id',auth()->user()->id)
                    ->where('end_time','>=',$cur_date)
                    ->where('is_cancelled',0)
                    ->orderBy('start_time','ASC')
                    ->get();
                    // dd($upcommit[0]->con_time);

        $past     = BookSession::where('student_id',auth()->user()->id)
                    ->whereDate('end_time', '<', $cur_date)
                    ->orderBy('start_time','ASC')
                    ->get();


        // $date = new \DateTime($upcommit->start_time);
        // $date->setTimezone(new \DateTimeZone($tz));
        // echo date('Y-m-d H:i:s', strtotime($upcommit->start_time));

        $country = DB::table('countries')->get();
        $merithub  = DB::table('merithub_creditionals')->first();
        return view('front.student-my-classes',compact('country','upcommit','upcommit1','past','tz','merithub'));
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
            Session::forget('timezone');
            $student_data = DB::table('student_details')->where('user_id',$user_id)->first();
            if($student_data !=Null){
                DB::table('student_details')->where('user_id',$user_id)->update($data1);
            }else{
                DB::table('student_details')->insert($data1);
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

    public function my_order(Request $request)
    {
        $user_id = Auth::user()->id;
        $order_data = Order::where(['user_id'=>$user_id,'is_completed'=>1])->get();

        return view('front.student-my-order', compact('order_data'));
    }

    public function my_order_details(Request $request, $order_id)
    {
        $order_id = base64_decode($order_id);
        $order_details_data = Order::find($order_id);
        return view('front.student-my-order-details', compact('order_details_data'));
    }
    public function delete(Request $request)
    {
        $user_id = Auth::user()->id;
        $id = $request->id;
        DB::beginTransaction();
        try{
            $student_data = DB::table('student_details')->where('user_id',$user_id)->update(['avtar' => Null]);

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
    public function email(Request $request){

        $rules = [
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
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
            $email =
            [
            'sender_email' => $request->email,
            'inext_email' => env('MAIL_USERNAME'),
            'sender_name' => Auth::user()->name,
            'referal' => $request->referal,
            'title' => 'Referal Code!',
            ];

            Mail::send('email.referal-test-email', $email, function ($messages) use ($email) {
                $messages->to($email['sender_email'])
                ->from($email['inext_email'], 'Latogo');
                $messages->subject("Join Our Immersive German Trial Class at Latogo – Your Friend's Referral Inside!");
            });
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
}
