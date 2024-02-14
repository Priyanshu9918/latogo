<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BookSession;
use Mail;

class Alert2Hour extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Alert:2Hour';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alert for student and teacher both just before 2 hours for session time';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        date_default_timezone_set('UTC');

        $date_time = date('Y-m-d H:i', strtotime('+2 hours'));

        $data = BookSession::where('start_time','=',$date_time)->where('is_cancelled',0)->with('Student.StudentDetail.TimeZone')->with('Teacher.TeacherSetting.TimeZone')->get();
        // echo $date_time.' // '.count($data).'</br>';
        $tz = 'Europe/Berlin';
        foreach($data as $val)
        {
            $s_name = '';
            if($val->Student!=null)
            {
                if($val->Student->StudentDetail!=null)
                {
                    if($val->Student->StudentDetail->TimeZone!=null)
                    {
                        $tz = ($val->Student->StudentDetail->TimeZone->timezone!=null)?$val->Student->StudentDetail->TimeZone->timezone:'';
                    }
                }

                $time_con02 = new \DateTime($val->start_time, new \DateTimeZone('UTC'));
                $time_con02->setTimezone(new \DateTimeZone($tz));
                $time_con03 = $time_con02->format("Y-m-d h:i A");

                $s_name=$val->Student->name;
                $email =[
                            'sender_email'  => $val->Student->email,
                            'inext_email'   => env('MAIL_USERNAME'),
                            'link'          => $val->student_url,
                            'name'          => $val->Student->name,
                            'title'         => 'Latogo Class 2 Hours Reminder',
                            'class_time'    => $time_con03,
                            'class_durection'=> $val->duration
                        ];

                Mail::send('email.student-class-2-hours-reminder', $email, function ($messages) use ($email) {
                    $messages->to($email['sender_email'])
                                ->from($email['inext_email'], 'Latogo');
                    $messages->subject("Latogo Class 2 Hours Reminder");
                });
            }

            if($val->Teacher!=null)
            {
                $tz = 'Europe/Berlin';
                if($val->Teacher->TeacherSetting!=null)
                {
                    if($val->Teacher->TeacherSetting->timezone!=null)
                    {
                        $tz = ($val->Teacher->TeacherSetting->TimeZone->timezone!=null)?$val->Teacher->TeacherSetting->TimeZone->timezone:'';
                    }
                }

                $time_con04 = new \DateTime($val->start_time, new \DateTimeZone('UTC'));
                $time_con04->setTimezone(new \DateTimeZone($tz));
                $time_con05 = $time_con04->format("Y-m-d h:i A");

                $email =[
                            'sender_email'  => $val->Teacher->email,
                            'inext_email'   => env('MAIL_USERNAME'),
                            'name'          => $val->Teacher->name,
                            's_name'        => $s_name,
                            'title'         => 'Latogo Class 2 Hours Reminder',
                            'class_time'    => $time_con05,
                            'class_durection'=> $val->duration
                        ];

                Mail::send('email.teacher-class-2-hours-reminder', $email, function ($messages) use ($email) {
                    $messages->to($email['sender_email'])
                                ->from($email['inext_email'], 'Latogo');
                    $messages->subject("Latogo Class 2 Hours Reminder");
                });
            }
        }

        // return Command::SUCCESS;
        // \Log::info('2 Hours Alert Running');
    }
}
