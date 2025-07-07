<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class CadPublicidade extends Model
{
    // use HasFactor

    protected $table = 'cad_publicidades';

    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'descricao',
        'imagem',
        'botao_link',
        'titulo_botao_link',
        'dt_inicio',
        'dt_fim',
    ];

    protected $casts = [
       'dt_inicio' => 'date',
       'dt_fim' => 'date',
    ];

    public function estados(): belongsToMany
    {
        return $this->belongsToMany(
            CadEstado::class,
            'cad_publicidade_estado',
            'id_publicidade',
            'id_estado',
        );
    }
}
