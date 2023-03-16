<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Curso extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'nome',
        'proposta',
        'carga_horaria',
        'modo_id',
        'activated',
    ];


    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];
    protected $with = ['modo'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/ava/cursos/'.$this->getKey());
    }

    public function modo()
    {
        return $this->belongsTo(CursoModo::class, 'modo_id', 'id');
    }
}
