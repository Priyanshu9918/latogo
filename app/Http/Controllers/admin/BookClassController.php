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

class BookClassController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $user = DB::table('bookclasses')->where('status', '<>', 2)->OrderBy('created_at','DESC')->get();

            $datatables = Datatables::of($user)
                ->editColumn('check', function ($row) {
                    return '<span class="form-check mb-0"><input type="checkbox" id="chk_sel_"><label class="form-check-label" for="chk_sel_"></label></span>';
                })
                ->editColumn('teacher_id', function ($row) {
                    $Users = DB::table('users')->where('id', $row->teacher_id)->where('status',1)->where('user_type',2)->first();
                    return ($Users!=null)?$Users->name:'';
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

                    $edit_url = url('/admin/bookclasses/edit', ['id' => base64_encode($row->id)]);

                    $action_2 = '<a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"
                                data-bs-toggle="tooltip" data-placement="top" title=""
                                data-bs-original-title="Edit" href="' . $edit_url . '">
                                <span class="icon">
                                    <span class="feather-icon">
                                    <i class="fas fa-edit text-info"></i>
                                    </span>
                                </span>
                            </a>';

                    $action_3 = '<a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover deleteBtn"
                                data-bs-toggle="tooltip" data-placement="top" title=""
                                data-bs-original-title="Delete" href="javascript:void(0)" data-id="' . base64_encode($row->id) . '">
                                <span class="icon">
                                    <span class="feather-icon">
                                    <i class="fas fa-trash text-danger"></i>
                                    </span>
                                </span>
                            </a>';
                    $action = '<div class="d-flex align-items-center">
                                <div class="d-flex">
                                    ' . $action_1 . '
                                    ' . $action_2 . '
                                    ' . $action_3 . '
                                </div>
                            </div>';
                    return $action;
                });

            $datatables = $datatables->rawColumns(['check', 'teacher_id', 'action'])->make(true);

            return $datatables;
        }

        return view('admin.bookclasses.index');
    }

    public function create(Request $request)
    {
        if ($request->isMethod('get')) {
            $teacher = DB::table('users')->where('status',1)->where('user_type',2)->get();
            return view('admin.bookclasses.create', compact('teacher'));
        }
        $rules = [
            'youtube_url' => 'required',
            'teacher_id' => 'required',
            'description' => 'required',
            'teaches' => 'required',
            'is_featured' => 'required',
            'student_count' => 'required',
            'lessons' => 'required|numeric',
            'success' => 'required|numeric',
            'rating' => 'required',
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
                'youtube_url' => $request->input('youtube_url'),
                'description' => $request->input('description'),
                'teacher_id' => $request->input('teacher_id'),
                'teaches' => $request->input('teaches'),
                'is_featured' => $request->input('is_featured'),
                'student_count' => $request->input('student_count'),
                'lessons' => $request->input('lessons'),
                'success' => $request->input('success'),
                'rating' => $request->input('rating'),
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ];

            DB::table('bookclasses')->insert($data);

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
    public function edit(Request $request)
    {
        $customer_id = base64_decode($request->id);

        if ($request->isMethod('get')) {
            $new = DB::table('bookclasses')->where('id', $customer_id)->first();
            $teacher = DB::table('users')->where('status', 1)->where('user_type',2)->get();
            return view('admin.bookclasses.edit', compact('new','teacher'));
        }
        $rules = [
            'youtube_url' => 'required|min:1|max:255',
            'teacher_id' => 'required',
            'description' => 'required',
            'teaches' => 'required',
            'is_featured' => 'required',
            'student_count' => 'required',
            'lessons' => 'required',
            'success' => 'required|numeric|max:100',
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validation->errors()
            ]);
        }

        $about = DB::table('bookclasses')->where('id', $customer_id)->first();

        DB::beginTransaction();
        try {

            $data = [
                'youtube_url' => $request->input('youtube_url'),
                'description' => $request->input('description'),
                'teacher_id' => $request->input('teacher_id'),
                'teaches' => $request->input('teaches'),
                'is_featured' => $request->input('is_featured'),
                'student_count' => $request->input('student_count'),
                'lessons' => $request->input('lessons'),
                'success' => $request->input('success'),
                'rating' => $request->input('rating'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            DB::table('bookclasses')->where('id', $customer_id)->update($data);

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
    public function Addwishlist(Request $request)
    {
        if(Auth::user()){
            $id = $request->id;
            $user_id = Auth::user()->id;
            $data = [
                'class_id' => $id,
                'user_id' => $user_id,
                'created_at' => date('Y-m-d H:i:s')
            ];
            DB::table('wishlists')->insert($data);

            return redirect()->back();
        }else{
            return view('front/login');
        }

    }
    public function removewishlist(Request $request)
    {
        if(Auth::user()){
            $id = $request->id;
            $user_id = Auth::user()->id;
            DB::table('wishlists')->where('class_id',$id)->where('user_id',$user_id)->delete();

            return redirect()->back();
        }else{
            return view('front/login');
        }

    }
    public function viewwishlist(Request $request)
    {
            $wish = DB::table('wishlists')->where('user_id', Auth::user()->id)->get();
            return view('front.wishlist',compact('wish'));
    }
}
