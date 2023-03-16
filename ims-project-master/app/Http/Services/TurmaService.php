<?php

namespace App\Http\Services;

use App\Models\Turma;

class TurmaService implements TurmaServiceInterface {
    private $model;

    /**
     * Class constructor.
     */
    public function __construct(Turma $model)
    {
        $this->model = $model;
    }

    public function listarTurmasAtivas()
    {
        return $this->model->where('activated', 1)->get();
    }

    public function getTurmasByCurso($cursoId)
    {
        return $this->model->where('curso_id', $cursoId)->get();
    }
}
