<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema; // <-- 1. AÑADE ESTA LÍNEA

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 2. Desactivamos temporalmente la revisión de claves foráneas
        Schema::disableForeignKeyConstraints();

        // Vaciamos la tabla
        Service::truncate();

        // 3. La volvemos a activar inmediatamente después
        Schema::enableForeignKeyConstraints();

        // Y ahora sí, creamos los registros
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