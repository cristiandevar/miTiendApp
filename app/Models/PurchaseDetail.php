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
        'quantity_ordered',
        'quantity_received',
        'cost_price',
        'active'
    ];
    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    
    }
    public function details() {
        return $this->hasMany(PurchaseDetail::class, 'purchase_id');
    }
}
