<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class CadEstado extends Model
{
    // use HasFactory;

    protected $table = 'cad_estados';

    public $timestamps = false;

    protected $fillable = [
        'descricao',
        'sigla',
    ];
    

    public function publicidades(): BelongsToMany
    {
        return $this->belongsToMany(
            CadPublicidade::class,
            'cad_publicidade_estado',
            'id_estado',
            'id_publicidade'
        );
    }
}
