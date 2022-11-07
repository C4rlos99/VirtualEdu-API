<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GuardarResultado extends FormRequest
{
    public function authorize()
    {
        $usuario = Auth::user();

        switch ($this->method()) {
            case "POST":
                return true;
            case "PATCH":
                $resultados = $usuario->resultados()->get();
                $resultado = $resultados->first(
                    function ($resultado) {
                        return $resultado->id == $this->id;
                    }
                );
                return $resultado != null;
        }
    }

    public function rules()
    {
        $rules = [
            "respuestas" => "required",
        ];

        if ($this->method() === "POST") {
            $rules["escenario_id"] = "required|exists:escenarios,id";
        }

        return $rules;
    }

    public function messages()
    {
        return [
            "escenario_id.required" => "El campo escenario_id es obligatorio",
            "escenario_id.exists" => "El campo escenario_id no es válido",

            "respuestas.required" => "El campo respuestas es obligatorio",
        ];
    }

    public function failedAuthorization()
    {
        throw new HttpResponseException(response()->json([
            "mensaje" => "Oh! Parece que no tienes acceso a este recurso",
            "status" => Response::HTTP_FORBIDDEN
        ], Response::HTTP_FORBIDDEN));
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            "mensaje" => "Oh! Algo no fue bien",
            "errores" => $validator->errors(),
            "status" => Response::HTTP_UNPROCESSABLE_ENTITY,
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
