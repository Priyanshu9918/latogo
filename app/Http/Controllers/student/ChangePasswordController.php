<?php
   
namespace App\Http\Controllers\student;
   
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\models\User;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Validation\Rule;

class ChangePasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     return view('changePassword');
    // } 
   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        $rules = [
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
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
        // $randomPassword = $request->input('new_password');

        // if($randomPassword){
        //     if (!preg_match("/^(?=.{10,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[$@%£!]).*$/", $randomPassword)){
        //             return response()->json([
        //                 'success' => false,
        //                 'custom'=>'yes',
        //                 'errors' => ['new_password'=>'Password must be atleast 10 characters long including (Atleast 1 uppercase letter(A–Z), Lowercase letter(a–z), 1 number(0–9), 1 non-alphanumeric symbol(‘$%£!’) !']
        //             ]);
        //     }
        // }

        $hashed_random_password = Hash::make($request->input('new_password'));

            $data = [
                'password'=> $hashed_random_password,
                'plan_password' => $request->input('new_password'),
            ];

        DB::table('users')->where('id',Auth::user()->id)->update($data);
        // User::find(Auth::user()->id)->update($data);
   
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
}
