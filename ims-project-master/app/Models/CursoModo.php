<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CursoModo extends Model
{
    use HasFactory;
    protected $table = "curso_modo";
    protected $fillable = ['nome', 'activated'];
}
