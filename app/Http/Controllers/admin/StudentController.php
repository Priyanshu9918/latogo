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
use App\Models\Credit;
use Mail;
use Str;

class StudentController extends Controller
{
    public function index(Request $request)
    {
            if($request->ajax())
            {
                $user = DB::table('users')->where('user_type',1)->where('status','<>',2)->OrderBy('created_at','DESC')->get();
                
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
    
                    $edit_url = url('/admin/student/edit',['id'=>base64_encode($row->id)]);
    
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
    
                    $action_4 = '<a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover creditBtn"
                                data-bs-toggle="tooltip" data-placement="top" title=""
                                data-bs-original-title="credit" href="javascript:void(0)" data-id="'.$row->id.'">
                                <span class="icon">
                                    <span class="feather-icon">
                                    <i class="fa fa-landmark text-warning"></i>
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
    
            return view('admin.student.index');
    }

    public function create(Request $request)
    {
        if($request->isMethod('get'))
        {
            return view('admin.student.create');
        }

        $rules = [
            'name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'email' => ['required','email:rfc,dns',Rule::unique('users')->where(fn ($query) => $query->where('status','<>', 2))],
            'phone' => 'required|regex:/^[0-9]+$/|min:5|unique:users',
            'password' => 'required|min:5',
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
            $reffer_code = str::random(10);
            $data = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'password' => $hashed_random_password,
                'reffer_code' => $reffer_code,
                'plan_password' => $request->input('password'),
                'user_type' =>1,
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

                Mail::send('email.student-email-content-and-subject-after-successfully-registration', $email, function ($messages) use ($email) {
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
            $student = DB::table('users')->where('user_type',1)->where('id',$customer_id)->first();

            return view('admin.student.edit',compact('student'));
        }

        $rules = [
            'name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'email' => 'required',
            'phone' => 'nullable|regex:/^[0-9]+$/|min:5',
            'password' => 'nullable|min:5',
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

            if($request->input('password')){

                $hashed_random_password = Hash::make($request->input('password'));

            }
            else
            {
                $hashed_random_password = $about->password;
                $current = $about->plan_password;
            }

            $data = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'plan_password' => $request->input('password') ?? $current,
                'password' => !empty($hashed_random_password) ? $hashed_random_password:NULL,
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
    public function credit(Request $request)
    {
        $user_id = $request->id;

        $price_master = DB::table('price_masters')->where('status',1)->get();

        $Purchased = DB::table('credits')->where('user_id', $user_id)->get();
        $sum = 0;
        foreach($Purchased as $data)
        {
            $val = DB::table('credits')->where('id', $data->id)->value('credit');
            $sum = $sum + $val;
        }

        return response()->json([
            'class' => $price_master,
            'user_id' => $user_id,
            'credit' => $sum,
            'success' =>true
        ]);
    }
    public function time(Request $request)
    {
        $pricemaster_id = $request->country_id;

        $time = DB::table('pricings')->where('price_master',$pricemaster_id)->whereNotNull('time')->where('status',1)->select('time')->groupBy('time')->get();

        return response()->json([
            'time' => $time,
            'price_master' => $pricemaster_id,
            'success' =>true
        ]);    
    }
    public function classtype(Request $request)
    {
        $pricing = DB::table('pricings')->where('time',$request->time)->where('price_master',$request->price)->where('status',1)->get();

        return response()->json([
            'pricing' => $pricing,
            'success' =>true
        ]);    
    }
    public function creditmanage(Request $request)
    {
        $rules = [
            'class' => 'required',
            'class_type' => 'required',
            'time' => 'required',
            'credit' => 'required',
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
            $cred = Credit::where('user_id',$request->user_id)->where('class_id',$request->class_type)->first();
        // dd($cred);

            if($cred == null){
                $order_item = new Credit;
                $order_item->user_id = $request->user_id;
                $order_item->class_id = $request->class_type;
                $order_item->credit = $request->credit;
                $order_item->save();
            }else{
                $cred_value = DB::table('credits')->where('user_id',$request->user_id)->where('class_id',$request->class_type)->first();
                $total_cred = $request->credit + $cred_value->credit;
                $credit = [
                    'credit' => $total_cred,
                ];
                $class1 = DB::table('credits')->where('user_id',$request->user_id)->where('class_id',$request->class_type)->update($credit);
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
    public function creditclass(Request $request){
       $id = $request->class1;
       $user_id = $request->user_id;
       $class_credit = DB::table('credits')->where('user_id',$user_id)->where('class_id',$id)->first();
       if($class_credit != null){
        $credit_value =  $class_credit->credit;
       }else{
        $credit_value =  0;
       }
       $price = DB::table('pricings')->where('id',$id)->first();
       $credit = $price->totle_class;

       return response()->json([
        'credit' => $credit,
        'credit_value' => $credit_value,
        'success' =>true
    ]);  
    }
}
