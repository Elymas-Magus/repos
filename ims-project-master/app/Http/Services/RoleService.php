<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Config;
use App\Http\Services\traits\RoleTrait;

class RoleService implements RoleServiceInterface {
    use RoleTrait;

    public function isAdministrador($user = null)
    {
        $this->guaranteeUser($user);
        return $this->checkRole(Config::get('constants.ROLES_NAMES.admin'));
    }

    public function isModerador($user = null)
    {
        $this->guaranteeUser($user);
        return $this->checkRole(Config::get('constants.ROLES_NAMES.moderador'));
    }

    public function isProfessor($user = null)
    {
        $this->guaranteeUser($user);
        return $this->checkRole(Config::get('constants.ROLES_NAMES.professor'));
    }

    public function isAluno($user = null)
    {
        $this->guaranteeUser($user);
        return $this->checkRole(Config::get('constants.ROLES_NAMES.aluno'));
    }
}
