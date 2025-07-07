<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicidadeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'imagem' => $this->imagem,
            'botao_link' => $this->botao_link,
            'titulo_botao_link' => $this->titulo_botao_link,
            'dt_inicio' => $this->dt_inicio,
            'dt_fim' => $this->dt_fim,
            'estados' => EstadoResource::collection($this->whenLoaded('estados')),
        ];
    }
}
