<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Helpers\Helper;

class BlogController extends Controller
{
    //
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $blog = DB::table('blogs')->where('status','<>',2)->get();
            // dd(1);
            $datatables = Datatables::of($blog)
            ->editColumn('check', function ($row) {
                return '<span class="form-check mb-0"><input type="checkbox" class="form-check-input check-select" id="chk_sel_"><label class="form-check-label" for="chk_sel_"></label></span>';
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

                $edit_url = url('/admin/blog/edit',['id'=>base64_encode($row->id)]);

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

            $datatables = $datatables->rawColumns(['check','action'])->make(true);

            return $datatables;
        }

        return view('admin.blog.index');
    }

    public function create(Request $request)
    {
        if($request->isMethod('get'))
        {
            // $parent_categories = DB::table('blog_categories')->where('status','<>',2)->get();

            return view('admin.blog.create');
        }

        $rules = [
            'title' => 'required',
            // 'blog_category' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
            'image' => 'required|mimes:jpeg,jpg,bmp,png,gif,svg'
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

            if($request->file('image')){

                    $image = $request->file('image');
                    $date = date('YmdHis');
                    $no = str_shuffle('123456789023456789034567890456789905678906789078908909000987654321987654321876543217654321654321543214321321211');
                    $random_no = substr($no, 0, 2);
                    $final_image_name = $date.$random_no.'.'.$image->getClientOriginalExtension();

                    $destination_path = public_path('/uploads/blogs/');
                    if(!File::exists($destination_path))
                    {
                        File::makeDirectory($destination_path, $mode = 0777, true, true);
                    }
                    $image->move($destination_path , $final_image_name);

            }
            if($request->file('b_image')){

                $b_image = $request->file('b_image');
                $date = date('YmdHis');
                $no = str_shuffle('123456789023456789034567890456789905678906789078908909000987654321987654321876543217654321654321543214321321211');
                $random_no = substr($no, 0, 2);
                $final_b_image_name = $date.$random_no.'.'.$b_image->getClientOriginalExtension();

                $destination_path = public_path('/uploads/blogs/');
                if(!File::exists($destination_path))
                {
                    File::makeDirectory($destination_path, $mode = 0777, true, true);
                }
                $b_image->move($destination_path , $final_b_image_name);

            }
            $slug = ltrim(rtrim(strtolower(str_replace(array(' ','/','%','°F','---','--'),'-',str_replace(array('&','?',"'",'"'),'',str_replace('(','',str_replace(')','', str_replace(',','',str_replace('®','',trim($request->title)))))))),'-'),'-');

            // check to see if any other slugs exist that are the same & count them

            $slug_count = DB::table('blogs')->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

            $slug = $slug_count ? "{$slug}-{$slug_count}" : $slug;

            $data = [
                'title' => $request->input('title'),
                'slug' => $slug,
                // 'blog_category' => $request->input('blog_category'),
                'short_description' => $request->input('short_description'),
                'long_description' => $request->input('long_description'),
                'image' => !empty($final_image_name) ? $final_image_name:NULL,
                'b_image' => !empty($final_b_image_name) ? $final_b_image_name:NULL,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ];

            DB::table('blogs')->insert($data);

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

    public function edit(Request $request)
    {
        $category_id = base64_decode($request->id);

        if($request->isMethod('get'))
        {
            $blog = DB::table('blogs')->where('id',$category_id)->first();

            // $parent_categories = DB::table('blog_categories')->where('status','<>',2)->get();

            return view('admin.blog.edit',compact('blog'));
        }

        $rules = [
            'title' => 'required',
            // 'blog_category' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,bmp,png,gif,svg'
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

            $blog = DB::table('blogs')->where('id',$category_id)->first();

            if($request->file('image')){

                    $image = $request->file('image');
                    $date = date('YmdHis');
                    $no = str_shuffle('123456789023456789034567890456789905678906789078908909000987654321987654321876543217654321654321543214321321211');
                    $random_no = substr($no, 0, 2);
                    $final_image_name = $date.$random_no.'.'.$image->getClientOriginalExtension();

                    $destination_path = public_path('/uploads/blogs/');
                    if(!File::exists($destination_path))
                    {
                        File::makeDirectory($destination_path, $mode = 0777, true, true);
                    }
                    $image->move($destination_path , $final_image_name);

            }
            else
            {
                $final_image_name = $blog->image;
            }
            if($request->file('b_image')){

                $b_image = $request->file('b_image');
                $date = date('YmdHis');
                $no = str_shuffle('123456789023456789034567890456789905678906789078908909000987654321987654321876543217654321654321543214321321211');
                $random_no = substr($no, 0, 2);
                $final_b_image_name = $date.$random_no.'.'.$b_image->getClientOriginalExtension();

                $destination_path = public_path('/uploads/blogs/');
                if(!File::exists($destination_path))
                {
                    File::makeDirectory($destination_path, $mode = 0777, true, true);
                }
                $b_image->move($destination_path , $final_b_image_name);

            }
            else
            {
                $final_b_image_name = $blog->b_image;
            }

            $data = [
                'title' => $request->input('title'),
                // 'blog_category' => $request->input('blog_category'),
                'short_description' => $request->input('short_description'),
                'long_description' => $request->input('long_description'),
                'image' => !empty($final_image_name) ? $final_image_name:NULL,
                'b_image' => !empty($final_b_image_name) ? $final_b_image_name:NULL,
                'status' => 1,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            DB::table('blogs')->where('id',$category_id)->update($data);

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
    public function fetch(Request $request)
    {
            $id = decrypt($request->id);

            $data = DB::table('blogs')->where('id',$id)->first();

            return view('front.blog-details',compact('data'));
    }
    public function view(Request $request)
    {
            $blogs = DB::table('blogs')->where('status',1)->get();

            return view('front.blogs',compact('blogs'));
    }
}
