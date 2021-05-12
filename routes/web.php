<?php

use App\Http\Controllers\ControladorAutenticacion;
use App\Http\Controllers\ControladorInstalacion;
use App\Http\Controllers\ControladorRedireccion;
use App\Http\Controllers\principal;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ControladorRedireccion::class, "redireccionar"]);

Route::get('login', [ControladorRedireccion::class, "redireccionar"]);
Route::post('login', [ControladorAutenticacion::class, "loguear"])->name("auth.loguear");

Route::get('registrar', [ControladorRedireccion::class, "redireccionar"]);
Route::post('registrar_email', [ControladorAutenticacion::class, "verificarCorreo"])->name("registro.verificarCorreo");
Route::post('registrar_password', [ControladorAutenticacion::class, "verificarContrasena"])->name("registro.verificarContrasena");
Route::post('registrar_confirm1', [ControladorAutenticacion::class, "enviarCorreoConfirmacion"])->name("registro.confirmar1");
Route::post('registrar_confirm2', [ControladorAutenticacion::class, "confirmarCodigo"])->name("registro.confirmar2");

Route::post('instalador', [ControladorInstalacion::class, "verificarEInstalarFicheros"])->name("instalador.verificacion");
