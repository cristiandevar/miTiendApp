<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    // Nombre de la tabla que se conecta a este Modelo
    protected $table = 'employees';

    // Nombres de las columnas que son modificables
    protected $fillable = [
        'lastname',
        'firstname',
        'dni',
        'email',
        'phone',
        'user_id'
    ];

    public function name() {
        return $this->lastname.' '.$this->firstname;
    }
}
