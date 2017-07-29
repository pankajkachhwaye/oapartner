<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

    class OrderModel extends Model
{
    protected $table = 'order';

    public function scopeGetPendingOrder($query){
        return $query->select('id','full_name', 'delivery','collection','product_detail','total')->where('status','pending');
    }

    public function scopeGetOrderById($query,$id){
            return $query->where('id',$id);
    }

    public function scopeAllPendingOrders($query){
        return $query->where('status','pending');
    }

    public function scopeAllConfirmedOrders($query){
        return $query->where('status','confirmed');
    }
}
