<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    use HasFactory;

    protected $fillable = ["cod_asignatura", "abreviatura", "nombre"];

    public function cursos(){
        return $this->hasMany(Curso::class);
    }

    public function alumnos(){
        return $this->hasMany(Alumno::class);
    }

    public function profesores(){
        return $this->hasMany(Profesor::class);
    }

    public function perteneceCursos(){
        return $this->belongsToMany(Curso::class);
    }

    public function perteneceAlumnos(){
        return $this->belongsToMany(Alumno::class);
    }

    public function perteneceProfesores(){
        return $this->belongsToMany(Profesor::class);
    }
}
