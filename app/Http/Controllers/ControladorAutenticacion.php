<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;

/**
 * Controlador encargado de todas las operaciones relacionadas con el registro y la creacion de sesiones, aparte.
 * Ofrece metodos para saber si el usuario esta realmente logueado
 *
 * @author Daniel caparros duran
 */
class ControladorAutenticacion extends Controller
{
    /**
     * Metodo loguear, este metodo se encargara de procesar la peticion de login
     * y generará un token de sesion que expirará a las 6 horas
     */
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
            //Si de verdad existe debemos de darle un token de sesion y llevarlo al home
            //ajax se encargará de mostrar los datos iniciales cuando seleccione las opciones

            //Generamos el token

            $tokenGenerado = Str::uuid()->toString();
            Profesor::where([
                ["email", "=", $email],
                ["password", "=", $contraCifrada]
            ])->limit(1)->update(["tokenSesion" => $tokenGenerado]);

            Cookie::queue("sesion", $tokenGenerado, 360);
        }
    }

    /**
     * Metodo estatico para ofrecer a otros controladores herramientas para verificar la sesion actual del token
     * que posee el usuario, si es que tiene
     */
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

    /**
     * Primera parte del registro, verificamos que el correo tanto exista como sea valido
     */
    public function verificarCorreo(Request $peticion)
    {
        $email = $peticion->input("email");
        if(preg_match("/.*@iesantoniogala.es/", $email) != 0){

            //Debemos de comprobar que el correo esta en la base de datos
            $maestroBuscar = Profesor::where("email", $email)->limit(1)->get();

            if(sizeof($maestroBuscar) == 0){
                return view("registrar", ["valor" => "noCorreo"]);
            }

            Cookie::queue("email", $email, 30);
            return view("registro.registro_contrasena");
        }else{
            return view("registrar", ["valor" => "errorCorreo"]);
        }
    }

    /**
     * Ciframos y verificamos que la contraseña sea correcta
     */
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

    /**
     * Metodo encargado de enviar un codigo de verificación al usuario
     */
    public function enviarCorreoConfirmacion(Request $peticion)
    {

        Mail::send([], [], function ($message) {
            $numGenerado = random_int(100000, 999999);
            Cookie::queue("tokenConfirmacion", $numGenerado, 15);

            $email = request()->cookie("email");

            $message->from('welcome@pagina', 'Admin');
            $message->to($email, $email)->subject("Codigo de verificacion")->setBody("Bienvenido \n Su codigo de verificacion es: ".$numGenerado);
        });

        return view("registro.registro_confirmar", ["valor" => true]);
    }


    /**
     * Metodo encargado de verificar el codigo de verificacion enviado por el metodo anterior e introducido por el usuario
     */
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
