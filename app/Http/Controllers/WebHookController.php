<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App\Models\BookSession;
use App\Models\QuizTestResult;


class WebHookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function status(Request $request)
    { 
        // die('reached');
        // Log::useDailyFiles(storage_path().'/logs/merit-hub-log.log');
        // Log::info(' / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / *');
        // Log::info($request->all());
        // Log::info(' / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / *');

        if($request->requestType=='classStatus')
        {
            $check_class = BookSession::where(['merithub_class_id'=>$request->classId])->first();

            if($check_class!=null)
            {
                $update = BookSession::where(['merithub_class_id'=>$request->classId])->update(['merithub_sub_class_id'=>$request->subClassId]);
            }
        }

        if($request->requestType=='recording')
        {
            $check_class = BookSession::where(['merithub_class_id'=>$request->classId])->first();

            if($check_class!=null)
            {
                $update = BookSession::where(['merithub_class_id'=>$request->classId])->update(['player_url'=>$request->player_url]);
            }
        }

        if($request->requestType=='classFiles')
        {
            $check_class = BookSession::where(['merithub_class_id'=>$request->classId])->first();

            if($check_class!=null)
            {
                $update = BookSession::where(['merithub_class_id'=>$request->classId])->update(['file_url'=>json_encode($request->Files)]);
            }
        }
        
    }
    public function drivefile(Request $request)
    {
        // Log::info('Quiz response started');
        // Log::info($request->all());
        if($request->has('webhookdata')){
            if($request->type=='file')
            {
                $data = QuizTestResult::where('user_id',$request->webhookdata['user_id'])->where('quiz_id',$request->webhookdata['quiz_id'])->first();
                if($data){
                    $val=[
                    'user_id' => $request->webhookdata['user_id'],
                    'quiz_id' => $request->webhookdata['quiz_id'],
                    'completion' => $request->completion,
                    ];
                    $update = QuizTestResult::where(['user_id'=>$request->webhookdata['user_id']])->where('quiz_id',$request->webhookdata['quiz_id'])->update($val);
                }else{
                    $quiz_result = new QuizTestResult;
                    $quiz_result->user_id = $request->webhookdata['user_id'];
                    $quiz_result->quiz_id = $request->webhookdata['quiz_id'];
                    $quiz_result->completion = $request->completion;
                    $quiz_result->save(); 
                }

                // Log::info('Quiz response completed');
    
            }
            if($request->type=='scorm')
            {
                $data = QuizTestResult::where('user_id',$request->webhookdata['user_id'])->where('quiz_id',$request->webhookdata['quiz_id'])->first();
                if($data){
                    $val=[
                    'user_id' => $request->webhookdata['user_id'],
                    'quiz_id' => $request->webhookdata['quiz_id'],
                    'scorm_data' => json_encode($request->scorm),
                    ];
                    $update = QuizTestResult::where(['user_id'=>$request->webhookdata['user_id']])->where('quiz_id',$request->webhookdata['quiz_id'])->update($val);
                }else{
                    $quiz_result = new QuizTestResult;
                    $quiz_result->user_id = $request->webhookdata['user_id'];
                    $quiz_result->quiz_id = $request->webhookdata['quiz_id'];
                    $quiz_result->scorm_data = json_encode($request->scorm);
                    $quiz_result->save(); 
                }

                // Log::info('Quiz response completed');
    
            }
        }

    }

    public function stripWebhook(Request $request)
    {
        Log::info(' / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / *');
        Log::info($request->all());
        Log::info(' / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / * / *');
    }


}
