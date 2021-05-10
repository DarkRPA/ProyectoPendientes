<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;

class ControladorAutenticacion extends Controller
{
    public function loguear(Request $peticion)
    {
        $email = $peticion->input("email");
        $contraCifrada = crypt($peticion->input("password"), "cifrador");

        //Debemos de buscar un maestro que tenga tanto el email como

        $buscarMaestro = Profesor::where([
            ["email", "=", $email],
            ["password", "=", $contraCifrada]
        ])->limit(1)->get();

        if(sizeof($buscarMaestro) == 0){
            return view("login", ["valor" => true]);
        }else{
            //Si de verdad existe debemos de
        }
    }
    public static function comprobarToken(String $token)
    {
        $buscarMaestro = Profesor::where("tokenSesion", $token)->limit(1)->get();
        if(sizeof($buscarMaestro) == 0){
            return false;
        }
        return true;
    }

    //-----------------------------------------------------------------
    //Apartado registro

    public function verificarCorreo(Request $peticion)
    {
        $email = $peticion->input("email");
        if(preg_match("/.*@iesantoniogala.es/", $email) != 0){
            Cookie::queue("email", $email, 30);
            return view("registro.registro_contrasena");
        }else{
            return view("registrar", ["valor" => "errorCorreo"]);
        }
    }

    public function verificarContrasena(Request $peticion)
    {
        $contra = crypt($peticion->input("password"), "cifrador");
        $contraConfirm = crypt($peticion->input("passwordConfirmar"), "cifrador");

        if($contra == $contraConfirm){
            Cookie::queue("password", $contra, 30);
            return view("registro.registro_confirmar");
        }else{
            return view("registro.registro_contrasena", ["valor" => "errorPassword"]);
        }
    }

    public function enviarCorreoConfirmacion(Request $peticion)
    {

        Mail::send([], [], function ($message) {
            $numGenerado = random_int(100000, 999999);
            Cookie::queue("tokenConfirmacion", $numGenerado, 15);

            $email = request()->cookie("email");

            $message->from('john@johndoe.com', 'Admin');
            $message->to($email, $email)->subject("Codigo de verificacion")->setBody("Bienvenido \n Su codigo de verificacion es: ".$numGenerado);
        });

        return view("registro.registro_confirmar", ["valor" => true]);
    }


    public function confirmarCodigo(Request $peticion)
    {
        $codigoEnviado = $peticion->input("codigo");
        $codigoCreado = $peticion->cookie("tokenConfirmacion");
        $correo = $peticion->cookie("email");
        $password = $peticion->cookie("password");

        if($codigoCreado == $codigoEnviado){
            //Debemos asignar a ese correo la contraseña y lo mandamos a loguearse
            $maestro = Profesor::where("email", $correo)->limit(1)->update(["password" => $password]);
            return redirect("/login");
        }else{
            return view("registro.registro_confirmar", ["error"=>"confirmacionErronea", "valor" => true]);
        }
    }
}
