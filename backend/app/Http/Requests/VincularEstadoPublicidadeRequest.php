<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VincularEstadoPublicidadeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'estado_ids' => 'required|array',
            'estado_ids.*' => 'integer|exists:cad_estados,id',
        ];
    }
}
