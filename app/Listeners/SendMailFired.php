<?php

namespace App\Listeners;
use App\Events\SendMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
use Mail;
use Auth;
class SendMailFired implements ShouldQueue
{
    use InteractsWithQueue;
    public function __construct()
    {
        
    }
    public function handle(SendMail $event)
    {
        $user = User::where('id',$event->userId)->first();
        $email =
            [
            'email' => $user->email,
            'sender_name' => $user->name,
            ];
        Mail::send('email.new-message', $email, function ($messages) use ($email) {
            $messages->to($email['email'])
            ->from(env('MAIL_USERNAME'), 'Latogo');
            $messages->subject("New Message!");
        });
    }
}
