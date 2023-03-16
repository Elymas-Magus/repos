<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Turma\BulkDestroyTurma;
use App\Http\Requests\Admin\Turma\DestroyTurma;
use App\Http\Requests\Admin\Turma\IndexTurma;
use App\Http\Requests\Admin\Turma\StoreTurma;
use App\Http\Requests\Admin\Turma\UpdateTurma;
use App\Http\Services\CursoServiceInterface;
use App\Http\Services\TurmaServiceInterface;
use App\Models\Curso;
use App\Models\Turma;
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

class TurmasController extends Controller
{
    private $turmaService;
    private $cursoService;

    /**
     * Class constructor.
     */
    public function __construct(TurmaServiceInterface $turmaService, CursoServiceInterface $cursoService)
    {
        $this->turmaService = $turmaService;
        $this->cursoService = $cursoService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexTurma $request
     * @return array|Factory|View
     */
    public function index(IndexTurma $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Turma::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'nome', 'curso_id', 'activated'],

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

        return view('admin.turma.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.turma.create');

        return view('admin.turma.create', [
            'cursos' => $this->cursoService->listarCursosAtivos(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTurma $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTurma $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $sanitized['curso_id'] = $sanitized['curso']['id'];

        // Store the Turma
        $turma = Turma::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('ava/turmas'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/turmas');
    }

    /**
     * Display the specified resource.
     *
     * @param Turma $turma
     * @throws AuthorizationException
     * @return void
     */
    public function show(Turma $turma)
    {
        $this->authorize('admin.turma.show', $turma);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Turma $turma
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Turma $turma)
    {
        $this->authorize('admin.turma.edit', $turma);

        return view('admin.turma.edit', [
            'turma' => $turma,
            'cursos' => $this->cursoService->listarCursosAtivos(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTurma $request
     * @param Turma $turma
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTurma $request, Turma $turma)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $sanitized['curso_id'] = $sanitized['curso']['id'];

        // Update changed values Turma
        $turma->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('ava/turmas'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/turmas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTurma $request
     * @param Turma $turma
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTurma $request, Turma $turma)
    {
        $turma->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTurma $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTurma $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('turmas')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
