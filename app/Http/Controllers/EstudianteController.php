<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Http\Requests\StoreEstudianteRequest;
use App\Http\Requests\UpdateEstudianteRequest;
use App\Http\Resources\estudianteResource;
use App\Http\Resources\cursoResource;
use App\Models\estudiante;
use App\Models\curso;
use App\Models\estudiante_curso;

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

    public function reloadEstudiantes(){
        $estudiante = estudiante::latest()->get();
        return response()->success(estudianteResource::collection($estudiante));
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
     * Update the specified resource in storage.
     */
    public function update(UpdateEstudianteRequest $request, Estudiante $estudiante)
    {
        $estudiante->nombre = $request->nombre;
        $estudiante->apellido = $request->apellido;
        $estudiante->edad = $request->edad;        
        $estudiante->save();
        return response()->success(['Estudiante actualizado correctamente!', new estudianteResource($estudiante)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estudiante $estudiante)
    {
        $estudiante_curso = estudiante_curso::where('estudiante_id',$estudiante->id);
        $estudiante_curso->delete();
        $estudiante->delete();
        return response()->success('Estudiante eliminado correctamente!');
    }
}
