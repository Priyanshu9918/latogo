<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;

class Order extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function Items(){
        return $this->hasMany(OrderItem::class, 'order_id' , 'id');
    }
}
