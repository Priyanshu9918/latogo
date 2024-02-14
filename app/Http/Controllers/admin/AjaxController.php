<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\User;
use Auth;
use Illuminate\Support\Facades\Validator;
use Mail;

class AjaxController extends Controller
{

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        ini_set('max_execution_time', '0');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function takeChangeStatusAction(Request $request)
    {
        $table_name = $request->table_name;
        $id = $request->id;
        $status = $request->status;

        if ($request->ajax() && !empty($table_name) && !empty($id) && isset($status)) {

            if ($status == 0) {
                $new_status = 1;
            }
            else {
                $new_status = 0;
            }

            DB::beginTransaction();

            $query = DB::table($table_name)->where('id', $id)->update(['status' => $new_status, 'updated_at'=>date('Y-m-d H:i:s')]);

            if ($query) {
                #commit transaction
                DB::commit();
                $data['code'] = 200;
                $data['result'] = 'success';
                $data['message'] = 'Action completed';
            }

            else
            {
                #rollback transaction
                DB::rollback();
                $data['code'] = 401;
                $data['result'] = 'failure';
                $data['message'] = 'Action can not be completed';
            }

        }

        else {
            $data['code'] = 401;
            $data['result'] = 'failure';
            $data['message'] = 'Unauthorized request';
        }

        return json_encode($data);
    }

    public function takeDeleteAction(Request $request)
    {
        $table_name = $request->table_name;
        $id = $request->id;

        if ($request->ajax() && !empty($table_name) && !empty($id)) {

            DB::beginTransaction();

            $query = DB::table($table_name)->where('id', $id)->update(['status' => 9, 'deleted_at'=>date('Y-m-d H:i:s')]);

            if ($query) {
                #commit transaction
                DB::commit();
                $data['code'] = 200;
                $data['result'] = 'success';
                $data['message'] = 'Action completed';
            }

            else
            {
                #rollback transaction
                DB::rollback();
                $data['code'] = 401;
                $data['result'] = 'failure';
                $data['message'] = 'Action can not be completed';
            }

        }

        else {
            $data['code'] = 401;
            $data['result'] = 'failure';
            $data['message'] = 'Unauthorized request';
        }

        return json_encode($data);
    }

    public function setDeleteAction(Request $request)
    {
         $table_name = $request->table_name;
         $id = base64_decode($request->id);

        if ($request->ajax() && !empty($table_name) && !empty($id)) {

            DB::beginTransaction();

             $table_data = DB::table($table_name)->where('id', $id)->first();

            // Check for Parent Category
            // if($table_name=='categories' && $table_data!=NULL && $table_data->parent==0)
            // {
            //     // Subcategories

            //     DB::table($table_name)->where('parent', $id)->update(['status' => 2, 'deleted_at'=>date('Y-m-d H:i:s')]);

            //     // Products

            //     DB::table('products')->whereRaw('FIND_IN_SET(?, category)', [$id])->update(['status' => 2, 'deleted_at'=>date('Y-m-d H:i:s')]);

            // }

            $query = DB::table($table_name)->where('id', $id)->update(['status' => 2, 'deleted_at'=>date('Y-m-d H:i:s')]);

            if ($query) {
                #commit transaction
                DB::commit();
                $data['code'] = 200;
                $data['result'] = 'success';
                $data['message'] = 'Action completed';
            }

            else
            {
                #rollback transaction
                DB::rollback();
                $data['code'] = 401;
                $data['result'] = 'failure';
                $data['message'] = 'Action can not be completed';
            }

        }
        else {
            $data['code'] = 401;
            $data['result'] = 'failure';
            $data['message'] = 'Unauthorized request';
        }

        return json_encode($data);
    }

    public function setStatusAction(Request $request)
    {
        $table_name = $request->table_name;

        $id = base64_decode($request->id);
        $type = base64_decode($request->type);

        //dd($request->all());
        DB::beginTransaction();
        if ($request->ajax() && !empty($table_name) && !empty($id)) {

            if(stripos($type,'disable')!==false)
            {
                $query = DB::table($table_name)->where('id', $id)->update(['status' => 0]);
                DB::commit();
                $data['code'] = 200;
                $data['success'] = true;
                $data['type'] = $type;
                $data['message'] = 'Status changed successfully.';
            }
            elseif(stripos($type,'enable')!==false)
            {
                $query = DB::table($table_name)->where('id', $id)->update(['status' => 1]);
                if($table_name == 'users')
                    {
                        $value = DB::table($table_name)->where('id', $id)->first();
                            $email =
                                [
                                'sender_email' => $value->email,
                                'inext_email' => env('MAIL_USERNAME'),
                                'sender_name' => $value->name,
                                'password' => $value->plan_password,
                                'title' => 'Teacher Aproved!!',
                            ];
                            Mail::send('email.admin-will-check-teachers-informations-and-approve-them-then-will-get-login-credentials-on-email', $email, function ($messages) use ($email) {
                                $messages->to($email['sender_email'])
                                ->from($email['inext_email'], 'Latogo');
                                $messages->subject("Account Has been Approved!!");
                            });
                    }
                DB::commit();
                $data['code'] = 200;
                $data['success'] = true;
                $data['type'] = $type;
                $data['message'] = 'Status changed successfully.';
            }
        }
        else
        {
            DB::rollback();
            $data['code'] = 401;
            $data['success'] = false;
            $data['message'] = 'Unauthorized request';
        }

        return response()->json($data);

    }

    public function pureDelete(Request $request)
    {
        $table_name = $request->table_name;
        $id = base64_decode($request->id);

        if ($request->ajax() && !empty($table_name) && !empty($id)) {

            DB::beginTransaction();

            $query = DB::table($table_name)->where('id', $id)->delete();

            if ($query) {
                #commit transaction
                DB::commit();
                $data['code'] = 200;
                $data['result'] = 'success';
                $data['message'] = 'Action completed';
            }

            else
            {
                #rollback transaction
                DB::rollback();
                $data['code'] = 401;
                $data['result'] = 'failure';
                $data['message'] = 'Action can not be completed';
            }

        }
        else {
            $data['code'] = 401;
            $data['result'] = 'failure';
            $data['message'] = 'Unauthorized request';
        }

        return json_encode($data);
    }

    public function stateList(Request $request)
    {
        $country_id = $request->country_id;

        $state = DB::table('states')->where('country_id',$country_id)->get();

        return response()->json($state);
    }

    public function cityList(Request $request)
    {
        $state_id = $request->state_id;

        $city = DB::table('cities')->where('state_id',$state_id)->get();

        return response()->json($city);
    }

    public function subCategoryList(Request $request)
    {
        $category_id = $request->category_id;

        $sub_category = DB::table('categories')->select('id','name')->where('parent',$category_id)->where('status','<>',2)->get();

        return response()->json($sub_category);
    }
    public function TimezoneList(Request $request)
    {
        $country_id = $request->country_id;

        $country = DB::table('countries')->where('id',$country_id)->first();

        $timezone = DB::table('time_zones')->where('country_code',$country->sortname)->get();

        return response()->json($timezone);
    }
}
