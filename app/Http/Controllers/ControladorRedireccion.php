<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use Illuminate\Http\Request;

class ControladorRedireccion extends Controller
{
    private $listaUriBlancos = [
        "login", "registros"
    ];

    public function redireccionar(Request $peticion)
    {
        $obtenerUri = $peticion->getRequestUri();
        $desfragmentarUri = $this->formatearUri($obtenerUri);
        $esBlanco = false;

        //dd($desfragmentarUri);
        for($i = 0; $i < sizeof($this->listaUriBlancos); $i++){
            if($desfragmentarUri[0] == $this->listaUriBlancos[$i]){
                $esBlanco = true;
            }
        }

        //echo "a ".$esBlanco;
        $parametros = array();
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

        if($esBlanco){
            return view($nombreVista, $parametros);
        }else{

            $cookie = $peticion->cookie("sesion");
            if(isset($cookie)){
                $buscarMaestro = Profesor::where("tokenSesion", $cookie)->limit(1)->get();

                if(isset($buscarMaestro)){
                    //-----
                }
            }

            return view("welcome");
        }
    }

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
