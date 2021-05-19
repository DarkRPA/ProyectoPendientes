<?php

namespace App\Http\Controllers;

use App\Models\instalado;
use App\Models\Profesor;
use Illuminate\Http\Request;

class ControladorRedireccion extends Controller
{
    private $listaUriBlancos = [
        "login", "registrar"
    ];

    private $listaUriAdmin = ["administracion"];


    /**
     * Metodo encargardo de la redireccion basico de las vistas. Este metodo debría de ser llamado por cada verbo GET que poseamos
     * en una ruta. El metodo agarrará las URI y la desfragmentará. Analizará que es lo que podría ser una vista o un parametro
     *
     * Y devuelve una vista parametrizada, en caso de que esa vista deba de ser accesible solo con una sesion se comprobará que el maestro
     * posee una sesion valida y, en caso positivo le llevará al objetivo, en caso negativo se le redigirá a la página inicial o cualquier
     * otra
     */
    public function redireccionar(Request $peticion)
    {
        $obtenerUri = $peticion->getRequestUri();
        $desfragmentarUri = $this->formatearUri($obtenerUri);
        $esBlanco = false;
        $esAdmin = false;

        /*if(!(instalado::first())){
            return view("instalacion.primer_inicio");
        }*/

        //dd($desfragmentarUri);
        for($i = 0; $i < sizeof($this->listaUriBlancos); $i++){
            if($desfragmentarUri[0] == $this->listaUriBlancos[$i]){
                $esBlanco = true;
            }
        }

        for($i = 0; $i < sizeof($this->listaUriAdmin); $i++){
            if($desfragmentarUri[0] == $this->listaUriAdmin[$i]){
                $esAdmin = true;
            }
        }

        //echo "a ".$esBlanco;
        $parametros = [];
        $nombreVista = "/";

        for($i = sizeof($desfragmentarUri); $i > 0; $i--){
            $seleccionado = $desfragmentarUri[$i-1];
            if($seleccionado == "") continue;
            if(!(view()->exists($seleccionado))){
                array_push($parametros, $seleccionado);
            }else{
                $nombreVista = $seleccionado;
                break;
            }
        }

        if($nombreVista == "/"){
            if($peticion->cookie("sesion") !== null){
                if(ControladorAutenticacion::comprobarToken($peticion->cookie("sesion"))){
                    $parametros["tieneSesion"] = true;
                }
            }
            return view("lobby", $parametros);
        }

        if($esBlanco){
            return view($nombreVista, $parametros);
        }else{
            $cookie = $peticion->cookie("sesion");
            if(isset($cookie)){
                $buscarMaestro = Profesor::where("tokenSesion", $cookie)->limit(1)->get();

                if(isset($buscarMaestro)){
                    if($esAdmin){
                        $atributos = $buscarMaestro->getAllAttributes();
                        if($atributos["es_admin"]){
                            return view($nombreVista, $parametros);
                        }
                    }else{
                        return view($nombreVista, $parametros);
                    }
                }
            }
        }
        return view("lobby");
    }

    /**
     * Metodo encargado del formateado de las URI, este metodo de lo que se encarga es de dividir las URI en trozos independientes ordenados
     * y convertidos a array
     *
     *
     */
    private function formatearUri(String $datos)
    {
        $arrayUri = array();
        $terminado = false;
        $uriEncontrada = $datos;

        $offset = 0;
        $vueltas = 0;

        $realOldOffset = 0;

        while(!$terminado){
            $oldOffset = $offset;

            if($vueltas != 0 && $realOldOffset == $offset){
                break;
            }

            $resultadoBarra = stripos($uriEncontrada, "/", $offset);
            $realOldOffset = $offset;
            $offset++;

            $descubrirFinal = stripos($uriEncontrada, "/", $offset);
            $offset = $descubrirFinal;

            if($resultadoBarra == false || $descubrirFinal == false){
                if($vueltas != 0){
                    $terminado = true;
                }
            }

            $vueltas++;



            $offsetCalculado = $descubrirFinal-$oldOffset;
            if($descubrirFinal){
                array_push($arrayUri, substr($uriEncontrada, $oldOffset+1, $offsetCalculado-1));
            }else{
                array_push($arrayUri, substr($uriEncontrada, $oldOffset+1));
            }
        }
        return $arrayUri;
    }
}
