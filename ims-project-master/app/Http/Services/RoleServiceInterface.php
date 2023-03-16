<?php

namespace App\Http\Services;

interface RoleServiceInterface {
    public function isAdministrador($user = null);
    public function isModerador($user = null);
    public function isProfessor($user = null);
    public function isAluno($user = null);
}
