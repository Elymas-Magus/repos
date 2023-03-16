<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AlunoTurma\BulkDestroyAlunoTurma;
use App\Http\Requests\Admin\AlunoTurma\DestroyAlunoTurma;
use App\Http\Requests\Admin\AlunoTurma\IndexAlunoTurma;
use App\Http\Requests\Admin\AlunoTurma\StoreAlunoTurma;
use App\Http\Requests\Admin\AlunoTurma\UpdateAlunoTurma;
use App\Models\AlunoTurma;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AlunoTurmaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexAlunoTurma $request
     * @return array|Factory|View
     */
    public function index(IndexAlunoTurma $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(AlunoTurma::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['aluno_id', 'turma_id', 'bol_current', 'data_matricula'],

            // set columns to searchIn
            ['']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.aluno-turma.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.aluno-turma.create');

        return view('admin.aluno-turma.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAlunoTurma $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreAlunoTurma $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the AlunoTurma
        $alunoTurma = AlunoTurma::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('ava/aluno-turmas'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/aluno-turmas');
    }

    /**
     * Display the specified resource.
     *
     * @param AlunoTurma $alunoTurma
     * @throws AuthorizationException
     * @return void
     */
    public function show(AlunoTurma $alunoTurma)
    {
        $this->authorize('admin.aluno-turma.show', $alunoTurma);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AlunoTurma $alunoTurma
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(AlunoTurma $alunoTurma)
    {
        $this->authorize('admin.aluno-turma.edit', $alunoTurma);


        return view('admin.aluno-turma.edit', [
            'alunoTurma' => $alunoTurma,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAlunoTurma $request
     * @param AlunoTurma $alunoTurma
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateAlunoTurma $request, AlunoTurma $alunoTurma)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values AlunoTurma
        $alunoTurma->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('ava/aluno-turmas'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/aluno-turmas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyAlunoTurma $request
     * @param AlunoTurma $alunoTurma
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyAlunoTurma $request, AlunoTurma $alunoTurma)
    {
        $alunoTurma->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyAlunoTurma $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyAlunoTurma $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    AlunoTurma::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
