<?php

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
Route::get('hola/manuel', [ControladorRedireccion::class, "redireccionar"]);
