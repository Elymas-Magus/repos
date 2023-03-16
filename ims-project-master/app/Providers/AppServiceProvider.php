<?php

namespace App\Providers;

use App\Http\Services\AlunoService;
use App\Http\Services\AlunoServiceInterface;
use App\Http\Services\CursoService;
use App\Http\Services\CursoServiceInterface;
use App\Http\Services\MatriculaService;
use App\Http\Services\MatriculaServiceInterface;
use App\Http\Services\ProfessorService;
use App\Http\Services\ProfessorServiceInterface;
use App\Http\Services\RoleService;
use App\Http\Services\RoleServiceInterface;
use App\Http\Services\TurmaService;
use App\Http\Services\TurmaServiceInterface;
use App\Http\Services\UserService;
use App\Http\Services\UserServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AlunoServiceInterface::class, AlunoService::class);
        $this->app->bind(CursoServiceInterface::class, CursoService::class);
        $this->app->bind(MatriculaServiceInterface::class, MatriculaService::class);
        $this->app->bind(ProfessorServiceInterface::class, ProfessorService::class);
        $this->app->bind(RoleServiceInterface::class, RoleService::class);
        $this->app->bind(TurmaServiceInterface::class, TurmaService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
