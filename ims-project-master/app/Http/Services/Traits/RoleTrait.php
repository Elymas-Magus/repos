<?php

namespace App\Http\Services\Traits;

use Illuminate\Support\Facades\Auth;

trait RoleTrait {
    private $user;

    private function guaranteeUser($user = null)
    {
        $this->user = $user ?? Auth::user();
    }

    private function checkRole($roleName)
    {
        return $this->user->getRoleNames()->contains($roleName);
    }
}
