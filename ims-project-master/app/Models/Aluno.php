<?php

namespace App\Models;

use Brackets\AdminAuth\Models\AdminUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aluno extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'registro_aluno',
        'data_nascimento',
        'fone',
        'email_responsavel',
        'ano_escolar',
        'nivel_escolaridade_id',
        'bol_nivel_concluido',
        'user_id',
    ];


    protected $dates = [
        'data_nascimento',
        'deleted_at',
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];
    protected $with = ['user', 'nivel_escolaridade'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/ava/alunos/'.$this->getKey());
    }

    public function user()
    {
        return $this->belongsTo(AdminUser::class, 'user_id', 'id');
    }

    public function nivel_escolaridade()
    {
        return $this->belongsTo(NiveisEscolaridade::class, 'nivel_escolaridade_id', 'id');
    }
}
