<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Nombre de la tabla que se conecta a este Model
    protected $table = 'categories';

    // Nombre de las columnas que son modificables
    protected $fillable = [
        'name'
    ];

    // INNER JOIN con la tabla Products
    // por medio de la FK category_id
    public function products() {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function seller() {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
