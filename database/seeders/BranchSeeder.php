<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;
// Eliminamos la importación de Schema
// use Illuminate\Support\Facades\Schema;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        // Eliminamos las líneas de disable/enable ForeignKeyConstraints
        // Schema::disableForeignKeyConstraints();
        Branch::truncate();
        // Schema::enableForeignKeyConstraints();

        Branch::create(['name' => 'Sucursal Principal - Centro']);
    }
}