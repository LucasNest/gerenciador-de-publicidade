<?php

namespace App\Http\Controllers;

use App\Models\CadPublicidade;
use Illuminate\Http\Request;
use App\Http\Requests\StorePublicidadeRequest;
use App\Http\Requests\VincularEstadoPublicidadeRequest;
use App\Actions\ValidarPeriodoPublicidade;

class PublicidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CadPublicidade::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('titulo', 'like', "%{$search}%");
        }

        if ($request->has('estado') && !empty($request->estado)) {
            $estadoFiltro = $request->estado;

            $query->whereHas('estados', function($q) use ($estadoFiltro) {
                if (is_array($estadoFiltro)) {
                    $q->whereIn('estado', $estadoFiltro);
                } else {
                    $q->where('estado', $estadoFiltro);
                }
            });
        }

        $publicidades = $query->with('estados')->get();
        return response()->json($publicidades);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePublicidadeRequest  $request, ValidarPeriodoPublicidade $validador)
    {
        $arquivo = $request->file('imagem');
        $nomeArquivo = md5($arquivo->getClientOriginalName() . strtotime("now")) . '.' . $arquivo->getClientOriginalExtension();
        $arquivo->move(public_path('img/publicidades'), $nomeArquivo);

        $data = $request->validated();
        $data['imagen'] = $nomeArquivo;

        $validador->execute($data['data_inicio'], $data['data_fim']);

        $publicidade = CadPublicidade::create($data);
        $publicidade->estados()->sync($request->estados);
        
        return response()->json([
            'message' => 'Publicidade criada com sucesso.'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(CadPublicidade $cadPublicidade)
    {
        return response()->json($cadPublicidade);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePublicidadeRequest $request, CadPublicidade $cadPublicidade, ValidarPeriodoPublicidade $validador)
    {
        $data = $request->validated();

        if ($request->hasFile('imagem')) {
            $arquivo = $request->file('imagem');
            $nomeArquivo = md5($arquivo->getClientOriginalName() . strtotime("now")) . '.' . $arquivo->getClientOriginalExtension();
            $arquivo->move(public_path('img/publicidades'), $nomeArquivo);
            $data['imagem'] = $nomeArquivo;

            unlink(public_path('img/publicidades/' . $cadPublicidade->imagen));
        }

        $validador->execute($data['data_inicio'], $data['data_fim'], $publicidade->id);

        $cadPublicidade->update($data);

        if ($request->has('estados')) {
            $cadPublicidade->estados()->sync($request->estados);
        }

        return response()->json([
            'message' => 'Publicidade atualizada com sucesso.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CadPublicidade $cadPublicidade)
    {
        unlink(public_path('img/publicidades/' . $cadPublicidade->imagen));
        $cadPublicidade->estados()->detach();
        $cadPublicidade->delete();

        return response()->json([
            'message' => 'Publicidade removida com sucesso.'
        ]);
    }

    public function vincularEstados(VincularEstadoPublicidadeRequest $request, CadPublicidade $cadPublicidade)
    {
        $data = $request->validated();

        $cadPublicidade->estados()->sync($data->estado_ids);

        return response()->json([
            'message' => 'Estados vinculados com sucesso.',
            'publicidade' => $cadPublicidade->load('estados'),
        ]);
    }
}
