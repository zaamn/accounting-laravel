<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceCart extends Model
{
    protected $fillable=[
        'customer',
        'currency',
        'date_time',
        'item_code',
        'product_id',
        'quantity',
        'unit_price',
        'discount',
        'total_price',
    ];
    public function product(){
        return $this->hasOne(Product::class,'id', 'product_id');
    }
}
