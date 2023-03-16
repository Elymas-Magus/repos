<?php

namespace App\Http\Services;

interface MatriculaServiceInterface {
    function getTurmaByAluno($alunoId);
    function getMatriculaAluno($alunoId);
    function matricularAluno($cursoId, $alunoId);
    function updateMatriculaAluno($turmaId, $alunoId);
}
