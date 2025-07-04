<?php

namespace App\Actions;

use App\Models\CadPublicidade;
use Illuminate\Validation\ValidationException;

class ValidarPeriodoPublicidade
{
    public function execute(string $dataInicio, string $dataFim, ?int $ignoreId = null): void
    {
        $query = CadPublicidade::where(function ($query) use ($dataInicio, $dataFim) {
            $query->where('data_inicio', '<=', $dataFim)
                  ->where('data_fim', '>=', $dataInicio);
        });

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages([
                'periodo' => 'Já existe uma publicidade ativa nesse período.'
            ]);
        }
    }
}