<?php

use App\Http\Controllers\EscenaController;
use App\Http\Controllers\EscenarioController;
use App\Http\Controllers\EscenaTipoController;
use App\Http\Controllers\RespuestaController;
use App\Http\Controllers\UsuarioController;
use App\Models\Respuesta;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(UsuarioController::class)->group(function () {
        Route::get("/usuario", "usuario");
        Route::post("/cerrar-sesion", "cerrarSesion");
    });

    Route::controller(RespuestaController::class)->group(function () {
        Route::post("/respuesta", "crearRespuesta");
        Route::patch("/respuesta/{id}", "modificarRespuesta");
        Route::delete("/respuesta/{id}", "eliminarRespuesta");
    });

    Route::controller(EscenaController::class)->group(function () {
        Route::get("/escenas/{escenario_id}", "obtenerEscenas");
        Route::get("/escenas-app/{escenario_id}", "obtenerEscenasApp");
        Route::get("/escena/{id}", "obtenerEscena");
        Route::post("/escena", "crearEscena");
        Route::patch("/escena/{id}", "modificarEscena");
        route::delete("/escena/{id}", "eliminarEscena");
    });

    Route::controller(EscenarioController::class)->group(function () {
        Route::get("/escenarios/{usuario_id}", "obtenerEscenarios");
        Route::get("/escenarios-app/{clave}", "obtenerEscenariosApp");
        Route::get("/escenario/{id}", "obtenerEscenario");
        Route::post("/escenario", "crearEscenario");
        Route::patch("/escenario/{id}", "modificarEscenario");
        route::patch("/eliminar-escenario/{id}", "eliminarEscenario");
    });

    Route::controller(EscenaTipoController::class)->group(function () {
        Route::get("/escena-tipos", "obtenerTipos");
    });
});

Route::controller(UsuarioController::class)->group(function () {
    Route::post("/registrar", "registrar");
    Route::post("/iniciar-sesion", "iniciarSesion");
});
