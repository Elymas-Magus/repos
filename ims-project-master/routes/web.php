<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('ava')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('admin-users')->name('admin-users/')->group(static function() {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('ava')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('ava')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('alunos')->name('alunos/')->group(static function() {
            Route::get('/',                                             'AlunosController@index')->name('index');
            Route::get('/create',                                       'AlunosController@create')->name('create');
            Route::post('/',                                            'AlunosController@store')->name('store');
            Route::get('/{aluno}/edit',                                 'AlunosController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'AlunosController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{aluno}',                                     'AlunosController@update')->name('update');
            Route::delete('/{aluno}',                                   'AlunosController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('ava')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('cursos')->name('cursos/')->group(static function() {
            Route::get('/',                                             'CursosController@index')->name('index');
            Route::get('/create',                                       'CursosController@create')->name('create');
            Route::post('/',                                            'CursosController@store')->name('store');
            Route::get('/{curso}/edit',                                 'CursosController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'CursosController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{curso}',                                     'CursosController@update')->name('update');
            Route::delete('/{curso}',                                   'CursosController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('ava')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('turmas')->name('turmas/')->group(static function() {
            Route::get('/',                                             'TurmasController@index')->name('index');
            Route::get('/create',                                       'TurmasController@create')->name('create');
            Route::post('/',                                            'TurmasController@store')->name('store');
            Route::get('/{turma}/edit',                                 'TurmasController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'TurmasController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{turma}',                                     'TurmasController@update')->name('update');
            Route::delete('/{turma}',                                   'TurmasController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('ava')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('disciplinas')->name('disciplinas/')->group(static function() {
            Route::get('/',                                             'DisciplinasController@index')->name('index');
            Route::get('/create',                                       'DisciplinasController@create')->name('create');
            Route::post('/',                                            'DisciplinasController@store')->name('store');
            Route::get('/{disciplina}/edit',                            'DisciplinasController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'DisciplinasController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{disciplina}',                                'DisciplinasController@update')->name('update');
            Route::delete('/{disciplina}',                              'DisciplinasController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('ava')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('aluno-turmas')->name('aluno-turmas/')->group(static function() {
            Route::get('/',                                             'AlunoTurmaController@index')->name('index');
            Route::get('/create',                                       'AlunoTurmaController@create')->name('create');
            Route::post('/',                                            'AlunoTurmaController@store')->name('store');
            Route::get('/{alunoTurma}/edit',                            'AlunoTurmaController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'AlunoTurmaController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{alunoTurma}',                                'AlunoTurmaController@update')->name('update');
            Route::delete('/{alunoTurma}',                              'AlunoTurmaController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('ava')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('publicacaos')->name('publicacaos/')->group(static function() {
            Route::get('/',                                             'PublicacaoController@index')->name('index');
            Route::get('/create',                                       'PublicacaoController@create')->name('create');
            Route::post('/',                                            'PublicacaoController@store')->name('store');
            Route::get('/{publicacao}/edit',                            'PublicacaoController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'PublicacaoController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{publicacao}',                                'PublicacaoController@update')->name('update');
            Route::delete('/{publicacao}',                              'PublicacaoController@destroy')->name('destroy');
        });
    });
});
