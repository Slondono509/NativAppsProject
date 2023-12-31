<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Http\Requests\StoreCursoRequest;
use App\Http\Requests\UpdateCursoRequest;
use App\Http\Resources\cursoResource;
use App\Http\Resources\estudianteResource;
use App\Models\curso;
use App\Models\estudiante;
use App\Models\estudiante_curso;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $curso = curso::latest()->get();
        $estudiante = estudiante::latest()->get();
        return Inertia::render('Curso/index', [
            'cursos' => cursoResource::collection($curso),
            'estudiantes' => estudianteResource::collection($estudiante),
        ]);
    }

    public function reloadCursos()
    {
        $curso = curso::latest()->get();
        return response()->success(cursoResource::collection($curso));
    }

    public function topCursos()
    {
        $seisMesesAtras = Carbon::now()->subMonths(6);
        $cursosConMasEstudiantes = DB::table('cursos')
            ->join('estudiante_cursos', 'cursos.id', '=', 'estudiante_cursos.curso_id')
            ->select('cursos.nombre', DB::raw('COUNT(estudiante_cursos.estudiante_id) as total_estudiantes'))
            ->where('estudiante_cursos.created_at', '>=', $seisMesesAtras)
            ->groupBy('cursos.id')
            ->orderByDesc('total_estudiantes')
            ->limit(3)
            ->get();
        return response()->success($cursosConMasEstudiantes);
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
        $estudiante_curso = estudiante_curso::where('curso_id', $curso->id);
        $estudiante_curso->delete();
        $curso->delete();
        return response()->success('Curso eliminado correctamente!');
    }
}
