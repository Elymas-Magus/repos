<?php

namespace App\Http\Services;

use Brackets\AdminAuth\Models\AdminUser;

class ProfessorService implements ProfessorServiceInterface {
    private $model;
    private $userService;
    private $roleService;

    /**
     * Class constructor.
     */
    public function __construct(
        AdminUser $model,
        UserServiceInterface $userService,
        RoleServiceInterface $roleService
    ) {
        $this->model = $model;
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    public function listarProfessoresAtivos()
    {
        return $this->userService->listarUsuariosAtivos()
            ->filter(fn($user) => $this->roleService->isProfessor($user))
            ->values();
    }
}
