<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $fillable = ["cod_alumno", "nombre", "apellido1", "apellido2"];

    public function curso(){
        return $this->hasOne(Curso::class);
    }

    public function tieneAsignaturas(){
        return $this->hasMany(Asignatura::class);
    }

    public function perteneceAsignaturas(){
        return $this->belongsToMany(Asignatura::class);
    }

    public function perteneceCurso(){
        return $this->belongsTo(Curso::class);
    }
}
