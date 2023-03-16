<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Disciplina\BulkDestroyDisciplina;
use App\Http\Requests\Admin\Disciplina\DestroyDisciplina;
use App\Http\Requests\Admin\Disciplina\IndexDisciplina;
use App\Http\Requests\Admin\Disciplina\StoreDisciplina;
use App\Http\Requests\Admin\Disciplina\UpdateDisciplina;
use App\Http\Services\CursoServiceInterface;
use App\Http\Services\ProfessorService;
use App\Http\Services\ProfessorServiceInterface;
use App\Http\Services\TurmaServiceInterface;
use App\Models\Disciplina;
use Brackets\AdminListing\Facades\AdminListing;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DisciplinasController extends Controller
{
    private $professorService;
    private $turmaService;

    /**
     * Class constructor.
     */
    public function __construct(
        ProfessorServiceInterface $professorService,
        TurmaServiceInterface $turmaService,
        CursoServiceInterface $cursoService
    ) {
        $this->professorService = $professorService;
        $this->turmaService = $turmaService;
        $this->cursoService = $cursoService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexDisciplina $request
     * @return array|Factory|View
     */
    public function index(IndexDisciplina $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Disciplina::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'nome', 'turma_id', 'professor_id', 'activated'],

            // set columns to searchIn
            ['id', 'nome']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.disciplina.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.disciplina.create');

        return view('admin.disciplina.create', [
            'professores' => $this->professorService->listarProfessoresAtivos(),
            'turmas' => $this->turmaService->listarTurmasAtivas(),
            'cursos' => $this->cursoService->listarCursosAtivos(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDisciplina $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreDisciplina $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        if (empty($sanitized['turma']) && empty($sanitized['curso'])) {
            abort (403, "Ao menos uma turma ou um curso deve ser selecionado");
        }
        if ($sanitized['lancar_para'] == 'lancar_para_turma') {
            $turmas = $sanitized['turma'];
        } elseif ($sanitized['lancar_para'] == 'lancar_para_curso') {
            $turmas = $this->turmaService->getTurmasByCurso($sanitized['curso']['id'])->toArray();
        }

        $novasDisciplinas = [];
        foreach ($turmas as $turma) {
            $novasDisciplinas[] = [
                'nome' => $sanitized['nome'],
                'turma_id' => $turma['id'],
                'professor_id' => $sanitized['professor']['id'],
                'activated' => true,
            ];
        }

        // Store the Disciplina
        $disciplina = Disciplina::insert($novasDisciplinas);

        if ($request->ajax()) {
            return ['redirect' => url('ava/disciplinas'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/disciplinas');
    }

    /**
     * Display the specified resource.
     *
     * @param Disciplina $disciplina
     * @throws AuthorizationException
     * @return void
     */
    public function show(Disciplina $disciplina)
    {
        $this->authorize('admin.disciplina.show', $disciplina);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Disciplina $disciplina
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Disciplina $disciplina)
    {
        $this->authorize('admin.disciplina.edit', $disciplina);


        return view('admin.disciplina.edit', [
            'disciplina' => $disciplina,
            'professores' => $this->professorService->listarProfessoresAtivos(),
            'turmas' => $this->turmaService->listarTurmasAtivas(),
            'cursos' => $this->cursoService->listarCursosAtivos(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDisciplina $request
     * @param Disciplina $disciplina
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateDisciplina $request, Disciplina $disciplina)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $sanitized['professor_id'] = $sanitized['professor']['id'];
        $sanitized['turma_id'] = $sanitized['turma']['id'];

        // Update changed values Disciplina
        $disciplina->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('ava/disciplinas'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/disciplinas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyDisciplina $request
     * @param Disciplina $disciplina
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyDisciplina $request, Disciplina $disciplina)
    {
        $disciplina->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyDisciplina $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyDisciplina $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('disciplinas')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
