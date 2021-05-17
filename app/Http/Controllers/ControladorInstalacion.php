<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControladorInstalacion extends Controller
{
    //detenido desarrollo
    public function verificarEInstalarFicheros(Request $peticion)
    {
        //$ficheroAlumnos = fopen($peticion->file("csvAlumnos")->path(), "r");
        $ficheroCursos = fopen($peticion->file("csvCursos")->path(), "r");
        //$ficheroAsignaturas = fopen($peticion->file("csvAsignaturas")->path(), "r");
        //Añadir fichero maestros aqui




        //$this->convertAlumnosArray($ficheroAlumnos);
        $this->convertCursosArray($ficheroCursos);
    }

    public function convertCursosArray($fichero)
    {
        $principal = array();

        while(($dato = fgetcsv($fichero, 0, ",")) != false){
            array_push($principal, $dato);
        }

        dd($principal);
        return $principal;
    }

    public function convertAsignaturasArray($fichero)
    {
        $principal = array();

        while(($dato = fgetcsv($fichero, 0, ",")) != false){
            array_push($principal, $dato);
        }

        return $principal;
    }

    public function convertAlumnosArray($fichero)
    {
        //Devolveremos un array con dos arrays, el primer array con toda la informacion no recursiva del usuario
        //y el segundo con esa informacion si recursiva, interpretada como cod_matricula + cod_asignatura
        $principal = array();
        $real = array();

        while(($dato = fgetcsv($fichero, 0, ",")) != false){
            array_push($principal, $dato);
        }

        $alumnos = array();
        $asig = array();

        for($i = 0; $i < sizeof($principal); $i++){
            if($i == 0){
                $alumno = array();
                for($x = 0; $x <sizeof($principal[$i]); $x++){
                    if($x == 6) continue;
                    array_push($alumno, $principal[$i][$x]);
                }

                $codAlumno = $alumno[0];
                $codAsig = $principal[$i][6];

                $asigAlu = array($codAlumno, $codAsig);

                array_push($asig, $asigAlu);
                array_push($alumnos, $alumno);
            }else{
                //Debemos comparar que el anterior no sea el mismo que el actual pues si lo es no se creara un nuevo alumno
                $pasadoAlumno = $principal[$i-1];
                $actualAlumno = $principal[$i];

                if($pasadoAlumno[0] == $actualAlumno[0]){
                    //El alumno anterior es el mismo que el actual
                    $codAlumno = $principal[$i][0];
                    $codAsig = $principal[$i][6];

                    $asigAlu = array($codAlumno, $codAsig);

                    array_push($asig, $asigAlu);
                }else{
                    //El alumno anterio NO es el mismo por lo que creamos un nuevo usuario
                    $alumno = array();
                    for($x = 0; $x <sizeof($principal[$i]); $x++){
                        if($x == 6) continue;
                        array_push($alumno, $principal[$i][$x]);
                    }

                    $codAlumno = $alumno[0];
                    $codAsig = $principal[$i][6];

                    $asigAlu = array($codAlumno, $codAsig);

                    array_push($asig, $asigAlu);
                    array_push($alumnos, $alumno);
                }
            }
        }

        array_push($real, $alumnos, $asig);

        return $real;
    }
}
