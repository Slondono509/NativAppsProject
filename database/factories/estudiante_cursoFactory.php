<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\estudiante;
use App\Models\curso;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class estudiante_cursoFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $estudiante = estudiante::pluck('id')->toArray();
        $curso = curso::pluck('id')->toArray();
        return [
            'estudiante_id' => $this->faker->randomElement($estudiante),
            'curso_id' => $this->faker->randomElement($curso)        
        ];
    }
   
}
