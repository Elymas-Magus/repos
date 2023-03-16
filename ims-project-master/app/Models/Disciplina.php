<?php

namespace App\Models;

use Brackets\AdminAuth\Models\AdminUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disciplina extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'nome',
        'turma_id',
        'professor_id',
        'activated',

    ];


    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];
    protected $with = ['turma', 'professor'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/ava/disciplinas/'.$this->getKey());
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class, 'turma_id', 'id');
    }

    public function professor()
    {
        return $this->belongsTo(AdminUser::class, 'professor_id', 'id');
    }
}
