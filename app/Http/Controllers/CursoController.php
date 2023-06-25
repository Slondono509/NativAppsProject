<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCursoRequest;
use App\Http\Requests\UpdateCursoRequest;
use App\Http\Resources\cursoResource;
use App\Models\curso;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = curso::latest()->get();
        return response()->success(cursoResource::collection($data));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCursoRequest $request)
    {
        $curso = curso::create([
            'nombre' => $request->nombre,
            'horario' => $request->horario,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);
        return response()->success(['Curso creado correctamente!', new cursoResource($curso)]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Curso $curso)
    {
        return response()->success([new cursoResource($curso)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curso $curso)
    {
        return response()->success([new cursoResource($curso)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCursoRequest $request, Curso $curso)
    {
        $curso->nombre = $request->nombre;
        $curso->horario = $request->horario;
        $curso->fecha_inicio = $request->fecha_inicio;
        $curso->fecha_fin = $request->fecha_fin;
        $curso->save();
        return response()->success(['Curso actualizado correctamente!', new cursoResource($curso)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $curso)
    {
        $curso->delete();
        return response()->success('Curso eliminado correctamente!');
    }
}
