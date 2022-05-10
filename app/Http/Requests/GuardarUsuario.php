<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class GuardarUsuario extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        switch ($this->method()) {
            case "POST":
                return [
                    "nombre" => "required",
                    "apellidos" => "required",
                    "correo" => "required|email:rfc,dns|unique:usuarios",
                    "password" => "required|min:4|max:12|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/",
                    "rePassword" => "required|same:password",
                ];
            default:
                break;
        }
    }

    public function messages()
    {
        return [
            "nombre.required" => "El campo nombre es obligatorio",
            "apellidos.required" => "El campo apellidos es obligatorio",

            "correo.required" => "El campo correo es obligatorio",
            "correo.email" => "El campo correo tiene que tener formato email",
            "correo.unique" => "El correo ya existe",

            "password.required" => "El campo contraseña es obligatorio",
            "password.min" => "La contraseña debe tener al menos 4 caracteres",
            "password.max" => "La contraseña puede tener como máximo 12 caracteres",
            "password.regex" => "La contraseña debe contener al menos 1 letra, 1 número y un caracter especial (!$#%)",

            "rePassword.required" => "El campo contraseña es obligatorio",
            "rePassword.same" => "Las contraseñas no coinciden",
        ];
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
