<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\estudiante;
use App\Models\curso;

class estudiante_curso extends Model
{
    use HasFactory;

    protected $table = 'estudiante_cursos';

    protected $fillable = [
        'estudiantes_id',
        'cursos_id',       
    ];

    public function estudiante() {
        return $this->belongsTo(estudiante::class);
    }

    public function curso() {
        return $this->belongsTo(curso::class);
    }

}
