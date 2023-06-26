<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Http\Requests\StoreEstudianteRequest;
use App\Http\Requests\UpdateEstudianteRequest;
use App\Http\Resources\estudianteResource;
use App\Http\Resources\cursoResource;
use App\Models\estudiante;
use App\Models\curso;

class EstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estudiante = estudiante::latest()->get();
        $curso = curso::latest()->get();
        return Inertia::render('Estudiante/index', [
            'estudiantes' => estudianteResource::collection($estudiante),         
            'cursos' => cursoResource::collection($curso),         
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEstudianteRequest $request)
    {
        $estudiante = estudiante::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'edad' => $request->edad,
            'email' => $request->email,
        ]);
        return response()->success(['Estudiante creado correctamente!', new estudianteResource($estudiante)]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Estudiante $estudiante)
    {
        return response()->success([new estudianteResource($estudiante)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estudiante $estudiante)
    {
        return response()->success([new estudianteResource($estudiante)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEstudianteRequest $request, Estudiante $estudiante)
    {
        $estudiante->nombre = $request->nombre;
        $estudiante->apellido = $request->apellido;
        $estudiante->edad = $request->edad;
        $estudiante->email = $request->email;
        $estudiante->save();
        return response()->success(['Estudiante actualizado correctamente!', new estudianteResource($estudiante)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estudiante $estudiante)
    {
        $estudiante->delete();
        return response()->success('Estudiante eliminado correctamente!');
    }
}
