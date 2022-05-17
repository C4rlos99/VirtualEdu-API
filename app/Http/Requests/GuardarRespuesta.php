<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GuardarRespuesta extends FormRequest
{
    public function authorize()
    {
        $usuario = Auth::user();

        switch ($this->method()) {
            case "POST":
                $escenarios = $usuario->escenarios()->get();
                $escenario = $escenarios->first(
                    function ($escenario) {
                        $escenas = $escenario->escenas()->get();
                        $escena = $escenas->first(
                            function ($escena) {
                                return $escena->id == $this->escena_id;
                            }
                        );
                        return $escena !== null;
                    }
                );

                return $escenario !== null && !$escenario->eliminado;
            case "PATCH":
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

                return $escenario !== null && !$escenario->eliminado;
        }
    }

    public function rules()
    {
        $rules = [
            "valores" => "required"
        ];

        if ($this->method() === "POST")
            $rules["escena_id"] = "required|exists:escenas,id";

        return $rules;
    }

    public function messages()
    {
        return [
            "valores.required" => "El campo valores es obligatorio",

            "escena_id.required" => "El campo escena_id es obligatorio",
            "escena_id.exists" => "El campo escena_id no es válido",
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
