<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponModel extends Model
{
    protected $table = 'coupon';

    public function scopeGetCouponByName($query,$coupon){
        return $query->where('coupon_code',$coupon);
    }
}
