<?php

namespace App\Http\Controllers;

use App\Models\CadPublicidade;
use Illuminate\Http\Request;
use App\Http\Requests\StorePublicidadeRequest;
use App\Http\Requests\VincularEstadoPublicidadeRequest;
use App\Actions\ValidarPeriodoPublicidade;
use App\Http\Resources\PublicidadeResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PublicidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $hoje = now()->startOfDay();
        CadPublicidade::whereDate('dt_fim', '<', $hoje)->delete();

        $query = CadPublicidade::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('titulo', 'like', "%{$search}%");
        }

        if ($request->has('estado') && !empty($request->estado)) {
            $estadoFiltro = $request->estado;

            $query->whereHas('estados', function($q) use ($estadoFiltro) {
                if (is_array($estadoFiltro)) {
                    $q->whereIn('sigla', $estadoFiltro);
                } else {
                    $q->where('sigla', $estadoFiltro);
                }
            });
        }

        $publicidadeAtiva = (clone $query)->whereDate('dt_inicio', '<=', $hoje)
                                     ->whereDate('dt_fim', '>=', $hoje)
                                     ->with('estados')
                                     ->get();

        $idsAtivas = $publicidadeAtiva->pluck('id');

        $publicidades = $query->whereNotIn('id', $idsAtivas)
                              ->with('estados')
                              ->get();
        return response()->json([
            'publicidades' => PublicidadeResource::collection($publicidades),
            'publicidade_ativas' => PublicidadeResource::collection($publicidadeAtiva),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePublicidadeRequest $request, ValidarPeriodoPublicidade $validador)
    {
        $data = $request->validated();
        if (!preg_match('/^data:image\/(\w+);base64,/', $data['imagem'], $matches)) {
            throw new \Exception('Formato de imagem inválido');
        }

        $validador->execute($data['dt_inicio'], $data['dt_fim']);

        $base64 = $request->input('imagem');
        $nomeOriginal = $request->input('imagemName');

        $base64 = substr($base64, strpos($base64, ',') + 1);
        $conteudo = base64_decode($base64);

        if ($conteudo === false) {
            throw new \Exception('Erro ao decodificar a imagem base64');
        }

        $limiteBytes = 4 * 1024 * 1024;

        if (strlen($conteudo) > $limiteBytes) {
            throw new \Exception('O tamanho da imagem excede o limite de 4MB.');
        }

        $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));
        $nomeBase = pathinfo($nomeOriginal, PATHINFO_FILENAME);

        $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($extensao, $extensoesPermitidas)) {
            throw new \Exception('Extensão de imagem não permitida. Insira uma imagem nos formatos: jpg, jpeg, png ou webp.');
        }

        $nomeFormatado = Str::slug($nomeBase);
        $nomeFinal = Str::uuid() . '-' . $nomeFormatado . '.' . $extensao;

        $caminho = "uploads/{$nomeFinal}";

        Storage::disk('public')->put($caminho, $conteudo);

        $data['imagem'] = 'storage/' . $caminho;
        unset($data['imagemName']);

        $publicidade = cadPublicidade::create($data);
        $publicidade->estados()->sync($request->estados);
        
        return response()->json([
            'message' => 'Publicidade criada com sucesso.'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(CadPublicidade $publicidade)
    {
        $publicidade->load('estados');
        if (!$publicidade) {
            return response()->json(['message' => 'Publicidade não encontrada'], 404);
        }
        
        return new PublicidadeResource($publicidade);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePublicidadeRequest $request, CadPublicidade $publicidade, ValidarPeriodoPublicidade $validador)
    {
        $data = $request->validated();
        $validador->execute($data['dt_inicio'], $data['dt_fim'], $publicidade->id);

        if (!empty($data['imagem']) && preg_match('/^data:image\/(\w+);base64,/', $data['imagem'], $matches)) {
            $base64 = substr($data['imagem'], strpos($data['imagem'], ',') + 1);
            $conteudo = base64_decode($base64);

            if ($conteudo === false) {
                throw new \Exception('Erro ao decodificar a imagem base64');
            }

            $limiteBytes = 4 * 1024 * 1024;
        
            if (strlen($conteudo) > $limiteBytes) {
                throw new \Exception('O tamanho da imagem excede o limite de 4MB.');
            }

            $nomeOriginal = $request->input('imagemName');

            $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));
            $nomeBase = pathinfo($nomeOriginal, PATHINFO_FILENAME);

            $nomeFormatado = Str::slug($nomeBase);

            $nomeFinal = Str::uuid() . '-' . $nomeFormatado . '.' . $extensao;

            $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];
            if (!in_array($extensao, $extensoesPermitidas)) {
                throw new \Exception('Extensão de imagem não permitida. Insira uma imagem nos formatos: jpg, jpeg, png ou webp.');
            }

            $caminho = "uploads/{$nomeFinal}";

            Storage::disk('public')->put($caminho, $conteudo);
            $data['imagem'] = 'storage/' . $caminho;

            if ($publicidade->imagem) {
                $caminhoAntigo = str_replace('storage/', '', $publicidade->imagem);
                    if (Storage::disk('public')->exists($caminhoAntigo)) {
                        Storage::disk('public')->delete($caminhoAntigo);
                    }
            }
        }

        unset($data['imagemName']);

        $publicidade->update($data);

        if ($request->has('estados')) {
            $publicidade->estados()->sync($request->estados);
        }

        return response()->json([
            'message' => 'Publicidade atualizada com sucesso.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CadPublicidade $publicidade)
    {
        if ($publicidade->imagem) {
            $caminhoImagem = str_replace('storage/', '', $publicidade->imagem);
            if (Storage::disk('public')->exists($caminhoImagem)) {
                Storage::disk('public')->delete($caminhoImagem);
            }
        }

        $publicidade->estados()->detach();
        $publicidade->delete();

        return response()->json([
            'message' => 'Publicidade removida com sucesso.'
        ]);
    }

    public function vincularEstados(VincularEstadoPublicidadeRequest $request, CadPublicidade $publicidade)
    {
        $data = $request->validated();

        $publicidade->estados()->sync($data['estado_ids']);

        return response()->json([
            'message' => 'Estados vinculados com sucesso.',
            'publicidade' => $publicidade->load('estados'),
        ]);
    }
}
