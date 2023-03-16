<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Publicacao\BulkDestroyPublicacao;
use App\Http\Requests\Admin\Publicacao\DestroyPublicacao;
use App\Http\Requests\Admin\Publicacao\IndexPublicacao;
use App\Http\Requests\Admin\Publicacao\StorePublicacao;
use App\Http\Requests\Admin\Publicacao\UpdatePublicacao;
use App\Models\Publicacao;
use Brackets\AdminListing\Facades\AdminListing;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PublicacaoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexPublicacao $request
     * @return array|Factory|View
     */
    public function index(IndexPublicacao $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Publicacao::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'titulo', 'criado_por', 'qtd_views', 'bol_permitir_comentario', 'bol_agendar', 'data_inicio'],

            // set columns to searchIn
            ['id', 'titulo', 'conteudo']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.publicacao.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.publicacao.create');

        return view('admin.publicacao.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePublicacao $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StorePublicacao $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $sanitized['criado_por'] = Auth::user()->getAuthIdentifier();

        // Store the Publicacao
        $publicacao = Publicacao::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('ava/publicacaos'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/publicacaos');
    }

    /**
     * Display the specified resource.
     *
     * @param Publicacao $publicacao
     * @throws AuthorizationException
     * @return void
     */
    public function show(Publicacao $publicacao)
    {
        $this->authorize('admin.publicacao.show', $publicacao);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Publicacao $publicacao
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Publicacao $publicacao)
    {
        $this->authorize('admin.publicacao.edit', $publicacao);


        return view('admin.publicacao.edit', [
            'publicacao' => $publicacao,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePublicacao $request
     * @param Publicacao $publicacao
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdatePublicacao $request, Publicacao $publicacao)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Publicacao
        $publicacao->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('ava/publicacaos'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/publicacaos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyPublicacao $request
     * @param Publicacao $publicacao
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyPublicacao $request, Publicacao $publicacao)
    {
        $publicacao->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyPublicacao $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyPublicacao $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('publicacaos')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
