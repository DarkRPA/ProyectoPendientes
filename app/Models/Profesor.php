<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    use HasFactory;

    protected $fillable = [
        "cod_profesor", "email", "nombre", "apellidos", "tokenSesion", "cod_verificacion", "verificado", "es_admin"
    ];
}
