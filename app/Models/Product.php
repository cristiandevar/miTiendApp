<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    // Nombre de la tabla que se conecta a este Modelo
    protected $table = 'products';

    // Nombres de las columnas que son modificables
    protected $fillable = [
        'nombre',
        'description',
        'precio',
        'imagen',
        'category_id'
    ];

    // INNER JOIN con la tabla Categories por medio de la FK category_id
    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // INER JOIN con la tabla Users por medio de la FK seller_id
    public function seller() {
        return $this.BelongsTo(User::class, 'seller_id');
    }
}
