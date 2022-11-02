<?php

namespace App\Http\Requests;

use App\Models\Escenario;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GuardarEscena extends FormRequest
{
    public function authorize()
    {
        $usuario = Auth::user();

        switch ($this->method()) {
            case "POST":
                $escenarios = $usuario->escenarios()->get();
                $escenario = $escenarios->first(
                    function ($escenario) {
                        return $escenario->id == $this->escenario_id && !$escenario->eliminado;
                    }
                );

                $autoriza = $escenario !== null;

                if ($autoriza && $this->respuesta_id) {
                    $escenas = $escenario->escenas()->get();
                    $escena = $escenas->first(
                        function ($escena) {
                            $respuestas = $escena->respuestas()->get();
                            $respuesta = $respuestas->first(function ($respuesta) {
                                return $respuesta->id == $this->respuesta_id;
                            });
                            return $respuesta !== null;
                        }
                    );

                    $autoriza = $autoriza && $escena;
                }

                return $autoriza;
            case "PATCH":
                $escenarios = $usuario->escenarios()->get();
                $escenario = $escenarios->first(
                    function ($escenario) {
                        $escenas = $escenario->escenas()->get();
                        $escena = $escenas->first(
                            function ($escena) {
                                return $escena->id == $this->id;
                            }
                        );
                        return $escena !== null;
                    }
                );

                return $escenario !== null && !$escenario->eliminado;;
        }
    }

    public function rules()
    {
        $rules = [
            "titulo" => "required",
            "url_video" => "required",
            "url_video_apoyo" => "prohibited",
            "url_video_refuerzo" => "prohibited",
        ];

        if ($this->method() === "POST") {
            $rules["escenario_id"] = "required|exists:escenarios,id";
            $rules["escena_tipo_id"] = "required|exists:escena_tipos,id";
            $rules["respuesta_id"] = "nullable|exists:respuestas,id";
        }

        switch ($this->escena_tipo_id) {
            case 3:
                $rules["url_video_refuerzo"] = "required";
            case 2:

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
            "titulo.required" => "El campo titulo es obligatorio",

            "escenario_id.required" => "El campo escenario_id es obligatorio",
            "escenario_id.exists" => "El campo escenario_id no es válido",

            "escena_tipo_id.required" => "El campo escena_tipo_id es obligatorio",
            "escena_tipo_id.exists" => "El campo escena_tipo_id no es válido",

            "respuesta_id.exists" => "El campo respuesta_id no es válido",

            "url_video.required" => "El campo url_video es obligatorio",
            "url_video_apoyo.required" => "El campo url_video_apoyo es obligatorio",
            "url_video_refuerzo.required" => "El campo url_video_refuerzo es obligatorio",

            "url_video_apoyo.prohibited" => "El campo url_video_apoyo solo puede estar presente para los tipos de escena 2 y 3",
            "url_video_refuerzo.prohibited" => "El campo url_video_refuerzo solo puede estar presente para el tipo de escena 3",
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
