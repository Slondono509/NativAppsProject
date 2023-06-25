<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class cursoFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => Str::random(20),                  
            'horario' => 'lunes - viernes 10 am/ 2 pm',                  
            'fecha_inicio' => '2023-06-01',                 
            'fecha_fin' => '2023-06-30',            
        ];
    }
   
}
