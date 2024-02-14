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
use Mail;

class ManagePricingController extends Controller
{
    //
    public function index(Request $request)
    {
        if($request->ajax()) 
        {
            
            $user = DB::table('pricings')->where('status','<>',2)->get();
            
            $datatables = Datatables::of($user)
            ->editColumn('check', function ($row) {
                return '<span class="form-check mb-0"><input type="checkbox" id="chk_sel_"><label class="form-check-label" for="chk_sel_"></label></span>';
            })
            ->editColumn('price_master', function ($row) {
                $price_master = DB::table('price_masters')->where('id',$row->price_master)->where('status','<>',2)->first();
                if(isset($price_master->title) != Null){
                    return  '<span>'.$price_master->title.'</span>';
                }
                else{
                    return  '<span>'.'NULL'.'</span>';
                }
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

                $edit_url = url('/admin/pricing/edit',['id'=>base64_encode($row->id)]);

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



                $action = '<div class="d-flex align-items-center">
                                <div class="d-flex">
                                    '.$action_1.'
                                    '.$action_2.'
                                    '.$action_3.'
                                </div>
                            </div>';
                return $action;
            });

            $datatables = $datatables->rawColumns(['check','price_master','created_at','action'])->make(true);

            return $datatables;
        }

        return view('admin.pricing-manage.index');
    }

    public function create(Request $request)
    {
        if($request->isMethod('get'))
        {
            $price_master = DB::table('price_masters')->where('status','<>',2)->get();
            return view('admin.pricing-manage.create',compact('price_master'));
            // return view('admin.user.create');
        }
        if($request->time){
            $rules = [
                'price_master' => 'required',
                'time' => 'required',
                'total_classes' => 'required|min:1|max:255',
                'price' => 'required|min:1|max:255',
                'total_price' => 'required|min:1|max:255'
            ];
            $custom =[
                'total_classes.required' => 'The Total class field required.'
            ]; 
        }else{
            $rules = [
                'price_master' => 'required',
                'time' => 'nullable',
                'total_classes' => 'required|min:1|max:255',
                'price' => 'required|min:1|max:255',
                'total_price' => 'required|min:1|max:255',
            ];
            $custom =[
                'total_classes.required' => 'The Total class field required.'
            ];
        }

        $validation = Validator::make($request->all(), $rules ,$custom);

        if ($validation->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validation->errors()
            ]);

        }


        DB::beginTransaction();
        try{

            $data = [
                'price_master' => $request->input('price_master'),
                'time' => $request->input('time'),
                'totle_class' => $request->input('total_classes'),
                'price' => $request->input('price'),
                'total_price' => $request->input('total_price'),
                'popular' => $request->input('popular'),
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ];

            DB::table('pricings')->insert($data);

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
            $price = DB::table('pricings')->where('id',$customer_id)->first();
            $price_master = DB::table('price_masters')->where('status','<>',2)->get();
            
            return view('admin.pricing-manage.edit',compact('price','price_master'));
        }

        if($request->time != null){
            $rules = [
                'price_master' => 'required',
                'time' => 'required',
                'total_classes' => 'required|min:1|max:255',
                'price' => 'required|min:1|max:255',
                'total_price' => 'required|min:1|max:255',
            ]; 
        }else{
            $rules = [
                'price_master' => 'required',
                'time' => 'nullable',
                'total_classes' => 'required|min:1|max:255',
                'price' => 'required|min:1|max:255',
                'total_price' => 'required|min:1|max:255',
            ];
        }

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validation->errors()
            ]);

        }

        $about = DB::table('price_masters')->where('id',$customer_id)->first();

        DB::beginTransaction();
        try{


            $data = [
                'price_master' => $request->input('price_master'),
                'time' => $request->input('time'),
                'totle_class' => $request->input('total_classes'),
                'price' => $request->input('price'),
                'total_price' => $request->input('total_price'),
                'popular' => $request->input('popular'),
                'status' => 1,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            DB::table('pricings')->where('id',$customer_id)->update($data);

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
    public function time(Request $request)
    {
        $price_master = DB::table('price_masters')->where('id',$request->active)->where('status',1)->first();
        $time = $price_master->time;
        if($time == 1){
            return response()->json([
                'success' =>true
            ]);
        }
        else{
            return response()->json([
                'success' =>false
            ]);  
        }
    }
    public function price(Request $request)
    {
        $pv_master = DB::table('price_masters')->where('id',$request->active)->where('status',1)->first();
        $tim = DB::table('pricings')->where('price_master',$request->active)->where('status',1)->first();
        if($tim->time != null){
            $price = DB::table('pricings')->where('price_master',$request->active)->where('time',$tim->time)->where('status','<>',2)->get();
        }else{
            $price = DB::table('pricings')->where('price_master',$request->active)->where('status',1)->get();
        }
        //dd($price);
        return view('front/pricing_t')->with(['price' => $price]);
        

    }
    public function timeprice(Request $request)
    {
        $price_master = DB::table('price_masters')->where('id',$request->id)->where('status',1)->first();
        $price = DB::table('pricings')->where('time',$request->active)->where('price_master',$price_master->id)->where('status',1)->get();
        return view('front/pricing_t')->with(['price_master' => $price_master , 'price' => $price]);

    }
    public function view(Request $request)
    {
        $pv_master = DB::table('price_masters')->where('id',1)->where('status',1)->first();
        $price = DB::table('pricings')->where('price_master',1)->where('time',30)->where('status',1)->get();
        $time = DB::table('pricings')->where('price_master',$pv_master->id)->whereNotNull('time')->where('status',1)->select('time')->groupBy('time')->get();

        return view('front/pricing')->with(['pv_master' => $pv_master , 'price' => $price ,'time' => $time]);
    }
    public function view1(Request $request)
    {
        $id = base64_decode($request->id);
        $pv_master = DB::table('price_masters')->where('id',1)->where('status',1)->first();
        $price = DB::table('pricings')->where('price_master',1)->where('time',30)->where('status',1)->get();
        $time = DB::table('pricings')->where('price_master',$pv_master->id)->whereNotNull('time')->where('status',1)->select('time')->groupBy('time')->get();

        return view('front/pricing')->with(['pv_master' => $pv_master , 'price' => $price ,'time' => $time, 'pr_id'=>$id]);
    }
    public function time1(Request $request)
    {
        $pv_master = DB::table('price_masters')->where('id',$request->active)->where('status',1)->first();
        $time = DB::table('pricings')->where('price_master',$pv_master->id)->whereNotNull('time')->where('status',1)->select('time')->groupBy('time')->get();

        return view('front/time')->with(['pv_master' => $pv_master,'time'=>$time]);
    }
}
