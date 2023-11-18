<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $table = 'sales';

    protected $fillable = [
        'user_id',
    ];

    public function details() {
        return $this->hasMany(SaleDetail::class, 'sale_id');
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
