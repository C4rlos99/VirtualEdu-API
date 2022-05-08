<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class GuardarEscena extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $usuario = Auth::user();

        $escenarios = $usuario->escenarios()->get();
        $escenario = $escenarios->first(
            function ($escenario) {
                return $escenario->id === $this->escenario_id;
            }
        );

        if ($autoriza = $escenario !== null && $this->escena_id) {
            $escenas = $escenario->escenas()->get();
            $escena = $escenas->first(
                function ($escena) {
                    return $escena->id === $this->escena_id;
                }
            );

            $autoriza = $autoriza && $escena;
        }

        return $autoriza;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            "escenario_id" => "required|exists:escenarios,id",
            "escena_tipo_id" => "required|exists:escena_tipos,id",
            "respuesta1" => "required",
            "url_video" => "required",
        ];

        if ($this->escena_id) {
            $rules["escena_id"] = "exists:escena_tipos,id";
        }

        switch ($this->escena_tipo_id) {
            case 3:
                $rules["respuesta3"] = "required";
                $rules["url_video_refuerzo"] = "required";
            case 2:
                $rules["respuesta2"] = "required";
                $rules["url_video_apoyo"] = "required";
                break;
            default:
                break;
        }

        return $rules;
    }
}
