<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EliminarRespuesta extends FormRequest
{
    public function authorize()
    {
        $usuario = Auth::user();

        $escenarios = $usuario->escenarios()->get();
        $escenario = $escenarios->first(
            function ($escenario) {
                $escenas = $escenario->escenas()->get();
                $escena = $escenas->first(
                    function ($escena) {
                        $respuestas = $escena->respuestas()->get();
                        $respuesta = $respuestas->first(
                            function ($respuesta) {
                                return $respuesta->id == $this->id;
                            }
                        );
                        return $respuesta !== null;
                    }
                );
                return $escena !== null;
            }
        );

        return $escenario !== null && !$escenario->eliminado;;
    }

    public function rules()
    {
        return [
            //
        ];
    }

    public function failedAuthorization()
    {
        throw new HttpResponseException(response()->json([
            "mensaje" => "Oh! Parece que no tienes acceso a este recurso",
            "status" => Response::HTTP_FORBIDDEN
        ], Response::HTTP_FORBIDDEN));
    }
}
