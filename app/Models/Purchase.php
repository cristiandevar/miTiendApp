<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $table = 'purchases';

    protected $fillable = [
        'supplier_id',
        'active'
    ];

    public function supplier() {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    
    }
    public function details() {
        // return SaleDetail::where('active', 1)
        //     ->where('sale_id',$this->id)
        //     ->latest();
        return $this->hasMany(PurchaseDetail::class, 'purchase_id');
    }
}
