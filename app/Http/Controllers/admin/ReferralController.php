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
class ReferralController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $user = DB::table('referrals')->where('status', '<>', 2)->get();

            $datatables = Datatables::of($user)
                ->editColumn('check', function ($row) {
                    return '<span class="form-check mb-0"><input type="checkbox" id="chk_sel_"><label class="form-check-label" for="chk_sel_"></label></span>';
                })
                ->editColumn('created_at', function ($row) {
                    return date('d M, Y', strtotime($row->created_at));
                })
                ->addColumn('action', function ($row) {
                    $action_1 = '';
                    if ($row->status == 0) {
                        $action_1 = '<a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover statusBtn"
                                        data-bs-toggle="tooltip" data-placement="top" title=""
                                        data-bs-original-title="Inactive" href="#" data-dc="' . base64_encode($row->id) . '" data-id="' . base64_encode($row->id) . '" data-type="' . base64_encode('enable') . '">
                                        <span class="icon">
                                        <i class="fas fa-circle-dot" style="color:red;"></i>
                                        </span>
                                    </a>
                                    <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover statusBtn d-none"
                                        data-bs-toggle="tooltip" data-placement="top" title=""
                                        data-bs-original-title="Active" href="#" data-ac="' . base64_encode($row->id) . '" data-id="' . base64_encode($row->id) . '" data-type="' . base64_encode('disable') . '">
                                        <span class="icon">
                                        <i class="fas fa-circle-dot" style="color:green;"></i>
                                        </span>
                                    </a>';
                    } else {
                        $action_1 = '<a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover statusBtn d-none"
                                        data-bs-toggle="tooltip" data-placement="top" title=""
                                        data-bs-original-title="Inactive" href="#" data-dc="' . base64_encode($row->id) . '" data-id="' . base64_encode($row->id) . '" data-type="' . base64_encode('enable') . '">
                                        <span class="icon">
                                        <i class="fas fa-circle-dot" style="color:red;"></i>
                                        </span>
                                    </a>
                                    <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover statusBtn"
                                        data-bs-toggle="tooltip" data-placement="top" title=""
                                        data-bs-original-title="Active" href="#" data-ac="' . base64_encode($row->id) . '" data-id="' . base64_encode($row->id) . '" data-type="' . base64_encode('disable') . '">
                                        <span class="icon">
                                        <i class="fas fa-circle-dot" style="color:green;"></i>
                                        </span>
                                    </a>';
                    }
                    $edit_url = url('/admin/referral/edit', ['id' => base64_encode($row->id)]);

                    $action_2 = '<a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"
                                data-bs-toggle="tooltip" data-placement="top" title=""
                                data-bs-original-title="Edit" href="' . $edit_url . '">
                                <span class="icon">
                                    <span class="feather-icon">
                                    <i class="fas fa-edit text-info"></i>
                                    </span>
                                </span>
                            </a>';

                    // $action_3 = '<a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover deleteBtn"
                    //             data-bs-toggle="tooltip" data-placement="top" title=""
                    //             data-bs-original-title="Delete" href="javascript:void(0)" data-id="' . base64_encode($row->id) . '">
                    //             <span class="icon">
                    //                 <span class="feather-icon">
                    //                 <i class="fas fa-trash text-danger"></i>
                    //                 </span>
                    //             </span>
                    //         </a>';
                    $action = '<div class="d-flex align-items-center">
                                <div class="d-flex">
                                    ' . $action_1 . '
                                    ' . $action_2 . '
                                </div>
                            </div>';
                    return $action;
                });

            $datatables = $datatables->rawColumns(['check', 'action'])->make(true);

            return $datatables;
        }

        return view('admin.referral.index');
    }
    public function create(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('admin.referral.create');
        }

        $rules = [
            'referral' => 'required|numeric',
            'referral_coupon' => 'required',
            'referring' => 'nullable|numeric',
            'referring_coupon' => 'nullable',
        ];
        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validation->errors()
            ]);
        }
        DB::beginTransaction();
        try {

            $data = [
                'referral' => $request->input('referral'),
                'referral_coupon' => $request->input('referral_coupon'),
                'referring' => $request->input('referring') ?? '1',
                'referring_coupon' => $request->input('referring_coupon') ?? '1',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ];

            DB::table('referrals')->insert($data);

            DB::commit();
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function edit(Request $request)
    {
        $customer_id = base64_decode($request->id);

        if ($request->isMethod('get')) {
            $new = DB::table('referrals')->where('id', $customer_id)->first();

            return view('admin.referral.edit', compact('new'));
        }

        $rules = [
            'referral' => 'required|numeric',
            'referral_coupon' => 'required|min:1|max:255',
            'referring' => 'nullable|numeric',
            'referring_coupon' => 'nullable|min:1|max:255',


        ];
        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validation->errors()
            ]);
        }

        $about = DB::table('referrals')->where('id', $customer_id)->first();

        DB::beginTransaction();
        try {

            $data = [
                'referral' => $request->input('referral'),
                'referral_coupon' => $request->input('referral_coupon'),
                'referring' => $request->input('referring') ?? '1',
                'referring_coupon' => $request->input('referring_coupon') ?? '1',
                'updated_at' => date('Y-m-d H:i:s')
            ];
            DB::table('referrals')->where('id', $customer_id)->update($data);

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

    public function coupon_remember(Request $request)
    {
        $coupan = DB::table('records_of_references')->where('status',0)->get();
        if ($coupan->count() > 0) {
            foreach($coupan as $key => $value){
                $user = DB::table('users')->where('id',$value->referring_user_id)->first();
                $email =
                [
                'sender_email' => $user->email,
                'inext_email' => env('MAIL_USERNAME'),
                'sender_name' => $user->name,
                'title' => 'Successfully Registered!',
                ];

                Mail::send('email.referal-coupan', $email, function ($messages) use ($email) {
                    $messages->to($email['sender_email'])
                    ->from($email['inext_email'], 'Latogo');
                    $messages->subject("Your 45-Minute Trial Class - Don't Miss Out!");
                });
            }
        }
        return response()->json([
            'success' => true
        ]);
    }
}
