<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TimeZone;

class StudentDetail extends Model
{
    use HasFactory;

    public function TimeZone()
    {
        return $this->hasOne(TimeZone::class,'id','timezone');
    }
}
