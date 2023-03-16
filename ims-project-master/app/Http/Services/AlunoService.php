<?php

namespace App\Http\Services;

use Brackets\AdminAuth\Models\AdminUser;

class AlunoService implements AlunoServiceInterface {
    private $model;

    /**
     * Class constructor.
     */
    public function __construct(AdminUser $model)
    {
        $this->model = $model;
    }

    public function listarAlunosAtivos()
    {
        return $this->model->where('activated', 1)->get();
    }

    // public function listarAlunosMatriculados()
    // {
    //     $alunos = $this->model->where('activated', 1)->get()->map(fn($aluno) => $aluno->id);
    //     return ;
    // }

    // public function listarAlunosNaoMatriculados()
    // {
    //     return $this->model->where('activated', 1)->get();
    // }
}
