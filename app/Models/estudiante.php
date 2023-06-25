<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\estudiante_curso;

class estudiante extends Model
{
    use HasFactory;

    protected $table = 'estudiantes';

    protected $fillable = [
        'nombre',
        'apellido',
        'edad',
        'email',
    ];

    public function estudiante_curso() {
        return $this->hasMany(estudiante_curso::class);
    }

}
