<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
}
