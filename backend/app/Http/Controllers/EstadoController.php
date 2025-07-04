<?php

namespace App\Http\Controllers;

use App\Models\CadEstado;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEstadoRequest;

class EstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cadEstado = CadEstado::all();
        return response()->json($cadEstado);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEstadoRequest $request)
    {
        $data = $request->validated();

        $cadEstado = CadEstado::create($data->all());
        return response()->json($cadEstado, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(CadEstado $cadEstado)
    {
        return response()->json($cadEstado);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreEstadoRequest $request, CadEstado $cadEstado)
    {
        $data = $request->validated();

        $cadEstado = CadEstado::update($data->all());
        return response()->json($cadEstado, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CadEstado $cadEstado)
    {
        $cadEstado->delete();
        return response()->json(null, 204);
    }
}
