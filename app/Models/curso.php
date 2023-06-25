<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\estudiante_curso;

class curso extends Model
{
    use HasFactory;

    protected $table = 'cursos';

    protected $fillable = [
        'nombre',
        'horario',
        'fecha_inicio',
        'fecha_fin',
    ];

    public function estudiante_curso() {
        return $this->hasMany(estudiante_curso::class);
    }

}
