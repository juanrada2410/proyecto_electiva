<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// Eliminamos la importación de Schema
// use Illuminate\Support\Facades\Schema;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Eliminamos las líneas de disable/enable ForeignKeyConstraints
        // Schema::disableForeignKeyConstraints();

        // Vaciamos la colección
        Service::truncate();

        // Schema::enableForeignKeyConstraints(); // Eliminado

        // Creamos los registros
        Service::create([
            'name' => 'Caja',
            'prefix' => 'C',
            'is_active' => true,
        ]);

        Service::create([
            'name' => 'Asesoría General',
            'prefix' => 'A',
            'is_active' => true,
        ]);

        Service::create([
            'name' => 'Créditos y Cartera',
            'prefix' => 'P',
            'is_active' => true,
        ]);
    }
}