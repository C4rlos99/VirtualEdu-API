<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GuardarVideo extends FormRequest
{
    public function authorize()
    {
        $usuario = Auth::user();

        $escenarios = $usuario->escenarios()->get();
        $escenario = $escenarios->first(
            function ($escenario) {
                return $escenario->id == $this->escenario_id && !$escenario->eliminado;
            }
        );

        return $escenario !== null;
    }

    public function rules()
    {
        return [
            "videos" => "required|array",
            "videos.*" => "required|mimetypes:video/mp4",
            "escenario_id" => "required|exists:escenarios,id",
        ];
    }

    public function messages()
    {
        return [
            "videos.required" => "El campo videos es obligatorio",
            "videos.array" => "El campo videos debe ser de tipo array",
            "videos.*.required" => "El campo videos debe contener algún archivo",
            "videos.*.mimetypes" => "Solo se aceptan ficheros .mp4",

            "escenario_id.required" => "El campo escenario_id es obligatorio",
            "escenario_id.exists" => "El campo escenario_id no es válido",
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
