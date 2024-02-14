<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pricing;
use App\Models\User;
use App\Models\TeacherSetting;
use App\Models\StudentDetail;
use App\Models\TimeZone;

class BookSession extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $dates=[
        'start_time',
        'end_time'
    ];

    public function Classis()
    {
        return $this->hasOne(Pricing::class,'id','class_id');
    }

    public function Student()
    {
        return $this->hasOne(User::class,'id','student_id');
    }

    public function Teacher()
    {
        return $this->hasOne(User::class,'id','teacher_id');
    }

    public function getConTimeAttribute()
    {
        if(auth()->user()->user_type==1)
        {
            $user       = StudentDetail::where('user_id',$this->student_id)->first();
        }
        else{
            $user       = TeacherSetting::where('user_id',$this->teacher_id)->first();
        }
        $tz = TimeZone::where('id',$user->timezone ?? 136)->first();
        $tz = $tz->timezone;
        $tm = $this->start_time;
        $t1 = new \DateTime($tm, new \DateTimeZone('UTC'));
        $t1->setTimezone(new \DateTimeZone($tz));
        $times = $t1->format("Y-m-d h:i A");
        return $times;
    }
}
