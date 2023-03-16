<?php

namespace App\Http\Services;

use Brackets\AdminAuth\Models\AdminUser;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class UserService implements UserServiceInterface {
    private $model;
    private $roleService;

    /**
     * Class constructor.
     */
    public function __construct(AdminUser $model, RoleServiceInterface $roleService)
    {
        $this->model = $model;
        $this->roleService = $roleService;
    }

    public function getUserById($userId)
    {
        return $this->model->where('id', $userId)->get()->first();
    }

    public function transformUserInAluno($userId)
    {
        DB::insert('insert into model_has_roles (role_id, model_type, model_id) values (?, ?, ?)', [
            Config::get('constants.ROLES.aluno'),
            'Brackets\AdminAuth\Models\AdminUser',
            $userId
        ]);
    }

    public function listarUsuariosAtivos()
    {
        return $this->model->where('activated', 1)->get();
    }

    public function updateUser($userId, $userInfo)
    {
        return $this->model->where('id', $userId)->update($userInfo);
    }
}
