<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = ["cod_curso", "nombre"];

    public function alumnos(){
        return $this->hasMany(Alumno::class);
    }

    public function asignatura(){
        return $this->hasMany(Asignatura::class);
    }

    public function profesores(){
        return $this->hasMany(Profesor::class);
    }

    public function perteneceAlumno(){
        return $this->belongsToMany(Alumno::class);
    }

    public function perteneceAsignatura(){
        return $this->belongsToMany(Asignatura::class);
    }

    public function perteneceMaestro(){
        return $this->belongsToMany(Profesor::class);
    }
}
