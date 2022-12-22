<?php

namespace App\Http\Requests;

use App\Models\Escenario;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ObtenerEscenas extends FormRequest
{
    public function authorize()
    {

        switch ($this->route()->uri) {
            case "api/escenas/{escenario_id}":
                $usuario = Auth::user();

                $escenarios = $usuario->escenarios()->get();
                $escenario = $escenarios->first(
                    function ($escenario) {
                        return $escenario->id == $this->escenario_id;
                    }
                );

                return $escenario !== null && !$escenario->eliminado;
            case "api/escenas-app/{escenario_id}":
                $escenarios = Escenario::all();
                $escenario = $escenarios->first(
                    function ($escenario) {
                        return $escenario->id == $this->escenario_id && $escenario->visible;
                    }
                );

                return $escenario !== null && !$escenario->eliminado;
        }
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
