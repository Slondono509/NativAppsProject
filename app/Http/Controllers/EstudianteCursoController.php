<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreEstudianteCursoRequest;
use App\Models\estudiante_curso;

class EstudianteCursoController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEstudianteCursoRequest $request)
    {
        estudiante_curso::create([
            'estudiante_id' => $request->estudiante_id,
            'curso_id' => $request->curso_id,           
        ]);
        return response()->success(['Estudiante asignado al curso!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(estudiante_curso $estudiante_curso)
    {
        $estudiante_curso->delete();
        return response()->success('Estudiante eliminado del curso correctamente!');
    }
}
