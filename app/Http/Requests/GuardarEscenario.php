<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class GuardarEscenario extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $usuario = Auth::user();

        return $usuario->id === $this->usuario_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "titulo" => "required",
            "visible" => "boolean",
            "usuario_id" => "required|exists:usuarios,id",
        ];
    }

    public function messages()
    {
        return [
            "titulo.required" => "El campo titulo es obligatorio",
            "visible.boolean" => "El campo visible debe de ser true o false",
            "usuario_id.required" => "El campo usuario_id es obligatorio",
            "usuario_id.exists" => "El campo usuario_id no es válido",
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
