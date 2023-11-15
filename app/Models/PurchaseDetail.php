<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;
    protected $table = 'purchase_details';

    protected $fillable = [
        'purchase_id',
        'product_id',
        'quantity',
        'cost_price',
        'suggested_price',
        'receipt_date',
        'active'
    ];
}
