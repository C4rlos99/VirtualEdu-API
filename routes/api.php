<?php

use App\Http\Controllers\EscenaController;
use App\Http\Controllers\EscenarioController;
use App\Http\Controllers\EscenaTipoController;
use App\Http\Controllers\UsuarioController;
use App\Models\Escenario;
use App\Models\EscenaTipo;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(EscenaController::class)->group(function () {
    Route::get("/escenas/{escenario_id}", "obtenerEscenas");
    Route::get("/escena/{id}", "obtenerEscena");
    Route::post("/escena", "crearEscena");
});

Route::controller(UsuarioController::class)->group(function () {
    Route::post("/usuario", "crearUsuario");
});

Route::controller(EscenarioController::class)->group(function () {
    Route::get("/escenarios/{usuario_id}", "obtenerEscenarios");
    Route::get("/escenario/{id}", "obtenerEscenario");
    Route::post("/escenario", "crearEscenario");
    route::delete("/escenario/{id}", "eliminarEscenario");
});

Route::controller(EscenaTipoController::class)->group(function () {
    Route::get("/escena-tipos", "obtenerTipos");
});
