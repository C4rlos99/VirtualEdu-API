<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ObtenerEscena extends FormRequest
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
                        return $escena->id == $this->id;
                    }
                );
                return $escena !== null;
            }
        );

        return $escenario !== null && !$escenario->eliminado;
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
