<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NiveisEscolaridade extends Model
{
    use HasFactory;
    protected $table = "niveis_escolaridade";
    protected $fillable = ['nome'];
}
