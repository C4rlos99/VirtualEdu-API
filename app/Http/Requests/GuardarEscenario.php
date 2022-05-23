<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class GuardarEscenario extends FormRequest
{
    public function authorize()
    {
        $usuario = Auth::user();

        switch ($this->method()) {
            case "POST":
                return true;
            case "PATCH":
                $escenarios = $usuario->escenarios()->get();
                $escenario = $escenarios->first(
                    function ($escenario) {
                        return $escenario->id == $this->id;
                    }
                );
                return $escenario != null && !$escenario->eliminado;
        }
    }

    public function rules()
    {
        $rules = [];

        if ($this->route()->uri === "api/escenario/{id}" || $this->route()->uri === "api/escenario") {
            $rules["titulo"] = "required";
            $rules["visible"] = "boolean";
        }

        return $rules;
    }

    public function messages()
    {
        return [
            "titulo.required" => "El campo titulo es obligatorio",
            "visible.boolean" => "El campo visible debe de ser true o false",
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
