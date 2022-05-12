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
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $usuario = Auth::user();

        switch ($this->method()) {
            case "POST":
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
            case "PUT":
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

                return $escenario !== null;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            "escena_tipo_id" => "required|exists:escena_tipos,id",
            "escena_id" => "nullable|exists:escenas,id",
            "respuesta1" => "required",
            "respuesta2" => "prohibited",
            "respuesta3" => "prohibited",
            "url_video" => "required",
            "url_video_apoyo" => "prohibited",
            "url_video_refuerzo" => "prohibited",
        ];

        if ($this->method() === "POST")
            $rules["escenario_id"] = "required|exists:escenarios,id";

        switch ($this->escena_tipo_id) {
            case 3:

                $rules["url_video_refuerzo"] = "required";
            case 2:

                $rules["url_video_apoyo"] = "required";
                break;
            case 4:
                $rules["respuesta2"] = "required";
                $rules["respuesta3"] = "required";
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

            "respuesta2.prohibited" => "El campo respuesta3 solo puede estar presente para el tipo de escena 4",
            "respuesta3.prohibited" => "El campo respuesta3 solo puede estar presente para el tipo de escena 4",


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
