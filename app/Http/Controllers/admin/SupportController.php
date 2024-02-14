<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Message;
use App\Lib\PusherFactory;
use Mail;
use Event;
use App\Events\SendMail;

class SupportController extends Controller
{
    //
    public function messages(Request $request)
    {
        $ids = array();
        $messages = Message::select('from_user','to_user')
                                    ->where(function ($query) use ($request) {
                                        $query->where('from_user', Auth::user()->id);
                                    })->orWhere(function ($query) use ($request) {
                                        $query->where('to_user', Auth::user()->id);
                                    })
                                    // ->groupBy('to_user','from_user')
                                    ->orderBy('created_at', 'ASC')
                                    ->get();
        foreach($messages as $msg)
        {
            if($msg->to_user!=Auth::user()->id)
            {
                $ids[] = $msg->to_user;
            }
            if($msg->from_user!=Auth::user()->id)
            {
                $ids[] = $msg->from_user;
            }

        }

        if(request()->has('user') && request()->get('user')!='')
        {
            $ids[] = request()->get('user');
        }
        $users = User::whereIn('id',$ids)->where('id', '!=', Auth::user()->id)->get();
        return view('admin.support.message', compact('users'));
    }

    public function getLoadLatestMessages(Request $request)
    {
        if (!$request->user_id) {
            return;
        }
        $messages = Message::where(function ($query) use ($request) {
            $query->where('from_user', Auth::user()->id)->where('to_user', $request->user_id);
        })->orWhere(function ($query) use ($request) {
            $query->where('from_user', $request->user_id)->where('to_user', Auth::user()->id);
        })->orderBy('created_at', 'ASC')->get(); //->limit(10)
        $return = [];
        foreach ($messages as $message) {
            $return[] = view('front.message-line')->with('message', $message)->render();
        }
        return response()->json(['state' => 1, 'messages' => $return]);
    }
    public function postSendMessage(Request $request)
    {
        if (!$request->to_user || !$request->message) {
            return;
        }
        $data = DB::table('messages')->where('from_user',Auth::user()->id)->where('to_user',$request->to_user)->whereDate('created_at', \Carbon\Carbon::today())->latest()->first();
        if($data == null){
            event(new SendMail($request->to_user));
        }

        $message = new Message();
        $message->from_user = Auth::user()->id;
        $message->to_user = $request->to_user;
        $message->content = $request->message;
        $message->save();
        // prepare some data to send with the response
        $message->dateTimeStr = date("Y-m-dTH:i", strtotime($message->created_at->toDateTimeString()));
        $message->dateHumanReadable = $message->created_at->diffForHumans();
        $message->fromUserName = $message->fromUser->name;
        $message->from_user_id = Auth::user()->id;
        $message->toUserName = $message->toUser->name;
        $message->to_user_id = $request->to_user;
        PusherFactory::make()->trigger('chat', 'send', ['data' => $message]);
        return response()->json(['state' => 1, 'data' => $message]);
    }

    public function getOldMessages(Request $request)
    {
        if (!$request->old_message_id || !$request->to_user)
            return;
        $message = Message::find($request->old_message_id);
        $lastMessages = Message::where(function ($query) use ($request, $message) {
            $query->where('from_user', Auth::user()->id)
                ->where('to_user', $request->to_user)
                ->where('created_at', '<', $message->created_at);
        })
            ->orWhere(function ($query) use ($request, $message) {
                $query->where('from_user', $request->to_user)
                    ->where('to_user', Auth::user()->id)
                    ->where('created_at', '<', $message->created_at);
            })
            ->orderBy('created_at', 'ASC')->limit(10)->get();
        $return = [];
        if ($lastMessages->count() > 0) {
            foreach ($lastMessages as $message) {
                $return[] = view('front.message-line')->with('message', $message)->render();
            }
            PusherFactory::make()->trigger('chat', 'oldMsgs', ['to_user' => $request->to_user, 'data' => $return]);
        }
        return response()->json(['state' => 1, 'data' => $return]);
    }
}
