<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PriceMaster;

class Pricing extends Model
{
    use HasFactory;

    public function MasterClass()
    {
        return $this->hasOne(PriceMaster::class,'id','price_master');
    }
}
