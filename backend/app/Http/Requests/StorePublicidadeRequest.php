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
            'imagem' => 'required|string',
            'imagemName' => 'required|string',
            'botao_link' => 'required|url',
            'titulo_botao_link' => 'required|string|max:255',
            'dt_inicio' => 'required|date|after_or_equal:today',
            'dt_fim' => 'required|date|after_or_equal:dt_inicio',
            'estados' => 'required|array|min:1',
            'estados.*' => 'exists:cad_estados,id',
        ];
    }

    
    public function messages(): array
    {
        return [
            'titulo.required' => 'O título é obrigatório.',
            'titulo.string' => 'O título deve ser um texto.',
            'titulo.max' => 'O título não pode ter mais que 255 caracteres.',

            'descricao.required' => 'A descrição é obrigatória.',
            'descricao.string' => 'A descrição deve ser um texto.',

            'imagem.required' => 'A imagem é obrigatória.',

            'botao_link.required' => 'O link do botão é obrigatório.',
            'botao_link.url' => 'O link do botão deve ser uma URL válida.',

            'titulo_botao_link.required' => 'O texto do botão é obrigatório.',
            'titulo_botao_link.string' => 'O texto do botão deve ser um texto.',
            'titulo_botao_link.max' => 'O texto do botão não pode ter mais que 255 caracteres.',

            'dt_inicio.required' => 'A data de início é obrigatória.',
            'dt_inicio.date' => 'A data de início deve ser uma data válida.',
            'dt_inicio.after_or_equal' => 'A data de início deve ser hoje ou uma data futura.',

            'dt_fim.required' => 'A data de fim é obrigatória.',
            'dt_fim.date' => 'A data de fim deve ser uma data válida.',
            'dt_fim.after_or_equal' => 'A data de fim deve ser igual ou posterior à data de início.',

            'estados.required' => 'É necessário selecionar pelo menos um estado.',
            'estados.array' => 'O campo estados deve ser um array.',
            'estados.min' => 'Você deve selecionar pelo menos um estado.',
            'estados.*.exists' => 'Um ou mais estados selecionados são inválidos.',
        ];
    }
}
