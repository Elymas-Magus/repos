<?php

namespace App\Http\Services;

use App\Models\Curso;

class CursoService implements CursoServiceInterface {
    private $model;

    /**
     * Class constructor.
     */
    public function __construct(Curso $model)
    {
        $this->model = $model;
    }

    public function listarCursosAtivos()
    {
        return $this->model->where('activated', 1)->get();
    }
}
