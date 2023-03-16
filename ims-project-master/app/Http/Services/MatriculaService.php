<?php

namespace App\Http\Services;

use App\Models\AlunoTurma;

class MatriculaService implements MatriculaServiceInterface {
    private $model;

    /**
     * Class constructor.
     */
    public function __construct(AlunoTurma $model)
    {
        $this->model = $model;
    }

    private function matriculaQuery($alunoId)
    {
        return $this->model->where(['aluno_id' => $alunoId, 'bol_current' => 1]);
    }

    private function finalizarMatricula($alunoId)
    {
        return $this->matriculaQuery($alunoId)->update(['bol_current' => 0]);
    }

    public function getTurmaByAluno($alunoId)
    {
        return $this->getMatriculaAluno($alunoId)->turma ?? null;
    }

    public function getMatriculaAluno($alunoId)
    {
        return $this->matriculaQuery($alunoId)->get()->first();
    }

    public function matricularAluno($turmaId, $alunoId)
    {
        return $this->model->create(['aluno_id' => $alunoId, 'turma_id' => $turmaId]);
    }

    public function updateMatriculaAluno($turmaId, $alunoId)
    {
        return $this->finalizarMatricula($alunoId) && $this->matricularAluno($turmaId, $alunoId);
    }
}
