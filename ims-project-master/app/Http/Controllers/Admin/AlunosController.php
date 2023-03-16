<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Aluno\BulkDestroyAluno;
use App\Http\Requests\Admin\Aluno\DestroyAluno;
use App\Http\Requests\Admin\Aluno\IndexAluno;
use App\Http\Requests\Admin\Aluno\StoreAluno;
use App\Http\Requests\Admin\Aluno\UpdateAluno;
use App\Http\Services\MatriculaServiceInterface;
use App\Http\Services\TurmaServiceInterface;
use App\Http\Services\UserService;
use App\Http\Services\UserServiceInterface;
use App\Models\Aluno;
use App\Models\NiveisEscolaridade;
use Brackets\AdminAuth\Models\AdminUser;
use Brackets\AdminListing\Facades\AdminListing;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class AlunosController extends Controller
{
    private $userService;
    private $turmaService;
    private $matriculaService;

    /**
     * Class constructor.
     */
    public function __construct(
        UserServiceInterface $userService,
        TurmaServiceInterface $turmaService,
        MatriculaServiceInterface $matriculaService
    ) {
        $this->userService = $userService;
        $this->turmaService = $turmaService;
        $this->matriculaService = $matriculaService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexAluno $request
     * @return array|Factory|View
     */
    public function index(IndexAluno $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Aluno::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'registro_aluno', 'data_nascimento', 'fone', 'email_responsavel', 'ano_escolar', 'nivel_escolaridade_id'],

            // set columns to searchIn
            ['id', 'registro_aluno', 'fone', 'email_responsavel']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.aluno.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.aluno.create');

        return view('admin.aluno.create', [
            'niveis_escolaridade' => NiveisEscolaridade::all(),
            'turmas' => $this->turmaService->listarTurmasAtivas(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAluno $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreAluno $request)
    {
        // Sanitize input
        $sanitized = $request->getModifiedData();

        // Store the User
        $adminUser = AdminUser::create($sanitized);
        $this->userService->transformUserInAluno($adminUser->id);

        $sanitized['user_id'] = $adminUser->id;
        $sanitized['nivel_escolaridade_id'] = $sanitized['nivel_escolaridade']['id'];

        // Store the Aluno
        $aluno = Aluno::create($sanitized);

        $this->matriculaService->matricularAluno($sanitized['turma']['id'], $aluno->id);

        if ($request->ajax()) {
            return ['redirect' => url('ava/alunos'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/alunos');
    }

    /**
     * Display the specified resource.
     *
     * @param Aluno $aluno
     * @throws AuthorizationException
     * @return void
     */
    public function show(Aluno $aluno)
    {
        $this->authorize('admin.aluno.show', $aluno);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Aluno $aluno
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Aluno $aluno)
    {
        $this->authorize('admin.aluno.edit', $aluno);

        $aluno->first_name = $aluno->user->first_name;
        $aluno->last_name = $aluno->user->last_name;
        $aluno->email = $aluno->user->email;
        $aluno->activated = $aluno->user->activated;
        $aluno->forbidden = $aluno->user->forbidden;
        $aluno->turma = $this->matriculaService->getTurmaByAluno($aluno->id);

        return view('admin.aluno.edit', [
            'aluno' => $aluno,
            'niveis_escolaridade' => NiveisEscolaridade::all(),
            'turmas' => $this->turmaService->listarTurmasAtivas(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAluno $request
     * @param Aluno $aluno
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateAluno $request, Aluno $aluno)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $this->userService->updateUser($aluno->user_id, [
            'first_name' => $sanitized['first_name'],
            'last_name' => $sanitized['last_name'],
            'password' => $sanitized['password'],
            'email' => $sanitized['email'],
        ]);

        $turma = $this->matriculaService->getTurmaByAluno($aluno->id);
        if ($turma->id != $sanitized['turma']['id']) {
            $this->matriculaService->updateMatriculaAluno($sanitized['turma']['id'], $aluno->id);
        }

        $sanitized['nivel_escolaridade_id'] = $sanitized['nivel_escolaridade']['id'];

        // Update changed values Aluno
        $aluno->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('ava/alunos'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/alunos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyAluno $request
     * @param Aluno $aluno
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyAluno $request, Aluno $aluno)
    {
        $aluno->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyAluno $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyAluno $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('alunos')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
