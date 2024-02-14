<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RecurringPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:RecurringPayment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule for daily Recurring Payment';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Log::info('Recurring Payment');
        
        $payment = DB::table('subscription_credit')->where('status',1)->get();
        foreach($payment as $pay){
            $now = date('Y-m-d');
            $nextPaymentDate = new \DateTime($pay->next_payment);
            $next_m = $nextPaymentDate->format('Y-m-d');
            // dd($next_m);

            if($next_m == $now){
                $class1 = DB::table('pricings')->where('id',$pay->class_id)->first();
                $cred_value = DB::table('credits')->where('user_id',$pay->user_id)->where('class_id',$pay->class_id)->first();
                if($cred_value){
                    $total_cred = ($pay->credit) + $cred_value->credit;
                    $credit = [
                        'credit' => $total_cred,
                    ];
                    DB::table('credits')->where('user_id',$pay->user_id)->where('class_id',$pay->class_id)->update($credit);    
                }else{
                    $total_cred = $pay->credit;
                    $credit = [
                        'user_id' => $pay->user_id,
                        'class_id' => $pay->class_id,
                        'credit' => $total_cred,
                        'created_at' => $now 
                    ];
                    DB::table('credits')->insert($credit);    
                }
                $t_timezone = DB::table('users')->where('id',$pay->user_id)->first();
                $t_timezones = DB::table('student_details')->where('user_id',$t_timezone->id)->first();
                $timezone = DB::table('time_zones')->where('id',$t_timezones->timezone)->first();
                $tz = $timezone->timezone ?? 'Asia/Kolkata';

                $current_time  = new \DateTime(date('Y-m-d H:i:s'), new \DateTimeZone($tz));
                $current_time->setTimezone(new \DateTimeZone('UTC'));
                $current_time1 = $current_time;

                $oneMonthLater = $current_time->modify('+1 month');
                $data = [
                    'purchase_at' => $now,
                    'next_payment' => $oneMonthLater,
                ];
                DB::table('subscription_credit')->where('id',$pay->id)->update($data);

            }
        }
        return Command::SUCCESS;

    }
}
