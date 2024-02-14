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

class CouponController  extends Controller
{
    //
    public function index(Request $request)
    {
        if($request->ajax())
        {
            
            $user = DB::table('records_of_references')->OrderBy('created_at','DESC')->get();
            
            $datatables = Datatables::of($user)
            ->editColumn('check', function ($row) {
                return '<span class="form-check mb-0"><input type="checkbox" id="chk_sel_"><label class="form-check-label" for="chk_sel_"></label></span>';
            })
            ->editColumn('referal', function ($row) {
                $referal = DB::table('users')->where('id',$row->referral_user_id)->where('status',1)->first();
                if(isset($referal->name) != Null){
                    return  '<span>'.$referal->name.'</span>';
                }
                else{
                    return  '<span>'.'NULL'.'</span>';
                }
            })
            ->editColumn('refering', function ($row) {
                $refering = DB::table('users')->where('id',$row->referring_user_id)->where('status',1)->first();
                if(isset($refering->name) != Null){
                    return  '<span>'.$refering->name.'</span>';
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
                                        <button type="button" class="btn btn-success">Available</button>
                                        </span>
                                    </a>
                                    <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover statusBtn d-none"
                                        data-bs-toggle="tooltip" data-placement="top" title=""
                                        data-bs-original-title="Active" href="#" data-ac="'.base64_encode($row->id).'" data-id="'.base64_encode($row->id).'" data-type="'.base64_encode('disable').'">
                                        <span class="icon">
                                        <button type="button" class="btn btn-warning">Applied</button>
                                        </span>
                                    </a>';
                }
                else
                {
                    $action_1 = '<a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover statusBtn d-none"
                                        data-bs-toggle="tooltip" data-placement="top" title=""
                                        data-bs-original-title="Inactive" href="#" data-dc="'.base64_encode($row->id).'" data-id="'.base64_encode($row->id).'" data-type="'.base64_encode('enable').'">
                                        <span class="icon">
                                        <button type="button" class="btn btn-success">Available</button>
                                        </span>
                                    </a>
                                    <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover statusBtn"
                                        data-bs-toggle="tooltip" data-placement="top" title=""
                                        data-bs-original-title="Active" href="#" data-ac="'.base64_encode($row->id).'" data-id="'.base64_encode($row->id).'" data-type="'.base64_encode('disable').'">
                                        <span class="icon">
                                        <button type="button" class="btn btn-warning">Applied</button>
                                        </span>
                                    </a>';
                }

                $action = '<div class="d-flex align-items-center">
                                <div class="d-flex">
                                    '.$action_1.'
                                </div>
                            </div>';
                return $action;
            });

            $datatables = $datatables->rawColumns(['check','referal','refering','action'])->make(true);

            return $datatables;
        }

        return view('admin.coupon.coupon');
    }
}
