<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlunoTurma extends Model
{
    protected $table = 'aluno_turma';

    protected $fillable = [
        'aluno_id',
        'turma_id',
        'bol_current',
        'data_matricula',

    ];


    protected $dates = [
        'data_matricula',
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/ava/aluno-turmas/'.$this->getKey());
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class, 'turma_id', 'id');
    }

    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'aluno_id', 'id');
    }
}
