<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pricing;

class Credit extends Model
{
    use HasFactory;

    public function Classis()
    {
        return $this->hasOne(Pricing::class,'id','class_id');
    }
}
