<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function customer(){
        return $this->hasOne(Customer::class,'id', 'customer_id');
    }
}
