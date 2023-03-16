<?php

namespace App\Http\Services;

interface UserServiceInterface {
    function getUserById ($userId);
    function transformUserInAluno($userId);
    function listarUsuariosAtivos();
    function updateUser($userId, $userInfo);
}
