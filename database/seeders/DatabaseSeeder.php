<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {        
        \App\Models\estudiante::factory(1000)->create();
        \App\Models\curso::factory(1000)->create();
        \App\Models\estudiante_curso::factory(1000)->create();
    }
}
