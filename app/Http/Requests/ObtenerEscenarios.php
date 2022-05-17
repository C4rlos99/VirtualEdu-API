<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ObtenerEscenarios extends FormRequest
{
    public function authorize()
    {
        $usuario = Auth::user();

        return $usuario->id == $this->usuario_id;
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
