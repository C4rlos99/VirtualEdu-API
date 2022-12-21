<?php

namespace App\Http\Requests;

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
        $escenarioVideos = null;

        $autoriza = false;

        switch ($this->method()) {
            case "POST":
                $escenarios = $usuario->escenarios()->get();
                $escenario = $escenarios->first(
                    function ($escenario) {
                        return $escenario->id == $this->escenario_id && !$escenario->eliminado;
                    }
                );

                $escenarioVideos = $escenario;

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
                break;
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

                $escenarioVideos = $escenario;

                $autoriza = $escenario !== null && !$escenario->eliminado;

                break;
        }

        if ($autoriza && $escenarioVideos !== null) {
            $videos = $escenarioVideos->videos()->get();
            $video = $videos->first(
                function ($video) {
                    return $video->id == $this->video_id;
                }
            );

            $autoriza = $autoriza && $video;

            if ($autoriza && $this->video_apoyo_id) {
                $videoApoyo = $videos->first(
                    function ($video) {
                        return $video->id == $this->video_apoyo_id;
                    }
                );

                $autoriza = $autoriza && $videoApoyo;

                if ($autoriza && $this->video_refuerzo_id) {
                    $videoRefuerzo = $videos->first(
                        function ($video) {
                            return $video->id == $this->video_refuerzo_id;
                        }
                    );

                    $autoriza = $autoriza && $videoRefuerzo;
                }
            }
        }

        return $autoriza;
    }

    public function rules()
    {
        $rules = [
            "titulo" => "required",
            "video_id" => "required|exists:videos,id",
            "video_apoyo_id" => "prohibited",
            "video_refuerzo_id" => "prohibited",
        ];

        if ($this->method() === "POST") {
            $rules["escenario_id"] = "required|exists:escenarios,id";
            $rules["escena_tipo_id"] = "required|exists:escena_tipos,id";
            $rules["respuesta_id"] = "nullable|exists:respuestas,id";
        }

        switch ($this->escena_tipo_id) {
            case 3:
                $rules["video_refuerzo_id"] = "required|exists:videos,id";
            case 2:
                $rules["video_apoyo_id"] = "required|exists:videos,id";
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

            "video_id.required" => "El campo video_id es obligatorio",
            "video_id.exists" => "El campo video_id no es válido",

            "video_apoyo_id.required" => "El campo video_apoyo_id es obligatorio",
            "video_apoyo_id.exists" => "El campo video_apoyo_id no es válido",

            "video_refuerzo_id.required" => "El campo video_refuerzo_id es obligatorio",
            "video_refuerzo_id.exists" => "El campo video_refuerzo_id no es válido",

            "video_apoyo_id.prohibited" => "El campo video_apoyo_id solo puede estar presente para los tipos de escena 2 y 3",
            "video_refuerzo_id.prohibited" => "El campo video_refuerzo_id solo puede estar presente para el tipo de escena 3",
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
