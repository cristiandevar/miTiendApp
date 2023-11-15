<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';

    protected $fillable = [
        'companyname',
        'email',
        'phone',
        'address',
        'active',
    ];

    public function productos(){
        return Product::where('active', 1)
            ->where('supplier_id', $this->id)
            ->latest()
            ->get();
    }
}
