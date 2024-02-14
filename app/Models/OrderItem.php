<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pricing;

class OrderItem extends Model
{
    use HasFactory;

    public function Classes(){
        return $this->hasOne(Pricing::class, 'id' , 'class_id');
    }
}
