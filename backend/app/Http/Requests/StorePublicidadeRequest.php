<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePublicidadeRequest extends FormRequest
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
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096', // até 4MB
            'botao_link' => 'required|url',
            'titulo_botao_link' => 'required|string|max:255',
            'dt_inicio' => 'required|date|after_or_equal:today',
            'dt_fim' => 'required|date|after_or_equal:dt_inicio',
            'estados' => 'required|array|min:1',
            'estados.*' => 'exists:cad_estado,id',
        ];
    }
}
