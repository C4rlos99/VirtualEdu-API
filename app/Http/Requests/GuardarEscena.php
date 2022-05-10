<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

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

        $autoriza = $escenario !== null;

        if ($autoriza && $this->escena_id) {
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
            $rules["escena_id"] = "exists:escenas,id";
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

    public function messages()
    {
        return [
            "escenario_id.required" => "El campo escenario_id es obligatorio",
            "escenario_id.exists" => "El campo escenario_id no es válido",

            "escena_tipo_id.required" => "El campo escena_tipo_id es obligatorio",
            "escena_tipo_id.exists" => "El campo escena_tipo_id no es válido",

            "escena_id.exists" => "El campo escena_id no es válido",

            "respuesta1.required" => "El campo respuesta1 es obligatorio",
            "respuesta2.required" => "El campo respuesta2 es obligatorio",
            "respuesta3.required" => "El campo respuesta3 es obligatorio",

            "url_video.required" => "El campo url_video es obligatorio",
            "url_video_refuerzo.required" => "El campo url_video_refuerzo es obligatorio",
            "url_video_apoyo.required" => "El campo url_video_apoyo es obligatorio",
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
