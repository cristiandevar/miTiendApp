<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;
    protected $table = 'sale_details';

    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'price',
        'active'
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    // public function sale(){
    //     return Sale::where('active', 1)
    //         ->where('product_id', $this->product_id)
    //         ->latest()
    //         ->get();
    // }
}
