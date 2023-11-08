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

    public function details() {
        // return SaleDetail::where('active', 1)
        //     ->where('sale_id',$this->id)
        //     ->latest();
        return $this->hasMany(SaleDetail::class, 'sale_id');
    }
    // public function products(){
    //     $products = SaleDetail::where('active', 1)
    //         ->where('sale_id',$this->id)
    //         ->latest()
    //         ->get();
        
    //     return c$products; 
    // }
    // public function total(){
    //     $details = $this->details();
    //     count($details->price);
    
    // public function productos(){
    //     return Product::where('active', 1)
    //         ->where('supplier_id', $this->id)
    //         ->latest()
    //         ->get();
    // }
}
