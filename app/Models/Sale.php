<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $table = 'sales';

    protected $fillable = [
        'employee_id',
    ];

    public function detalles() {
        return SalesDetails::where('active', 1)
            ->where('sales_id',$this->id)
            ->latest()
            ->get();
    }
    // public function productos(){
    //     return Product::where('active', 1)
    //         ->where('supplier_id', $this->id)
    //         ->latest()
    //         ->get();
    // }
}
