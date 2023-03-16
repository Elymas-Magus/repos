<?php

namespace App\Http\Services;

interface TurmaServiceInterface {
    function listarTurmasAtivas();
    function getTurmasByCurso($cursoId);
}
