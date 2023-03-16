<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publicacao extends Model
{
    use SoftDeletes;
    protected $table = 'publicacao';

    protected $fillable = [
        'titulo',
        'conteudo',
        'criado_por',
        'qtd_views',
        'bol_permitir_comentario',
        'bol_agendar',
        'data_inicio',

    ];


    protected $dates = [
        'data_inicio',
        'deleted_at',
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/ava/publicacaos/'.$this->getKey());
    }
}
