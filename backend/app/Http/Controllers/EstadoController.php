<?php

namespace App\Http\Controllers;

use App\Models\CadEstado;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEstadoRequest;
use App\Http\Resources\EstadoResource;

class EstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estado = CadEstado::all();

        return response()->json([
            'estados' => EstadoResource::collection($estado),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEstadoRequest $request)
    {
        $data = $request->validated();

        $estado = CadEstado::create($data);
        return response()->json([
            'estado' => new EstadoResource($estado->fresh()),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(CadEstado $estado)
    {
        return EstadoResource::collection($estado);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreEstadoRequest $request, CadEstado $estado)
    {
        $data = $request->validated();

        $estado->update($data);
        return response()->json([
            'message' => 'Estado atualizado com sucesso.',
            'estado' => new EstadoResource($estado->fresh()),
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CadEstado $estado)
    {
        $estado->delete();
        return response()->json(null, 204);
    }
}
