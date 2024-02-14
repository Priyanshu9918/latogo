<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TimeZone;

class TeacherSetting extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function TimeZone()
    {
        return $this->hasOne(TimeZone::class,'id','timezone');
    }
}
