<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MostrarEscenas extends FormRequest
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
                return $escenario->id == $this->escenario_id;
            }
        );

        return $escenario != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
