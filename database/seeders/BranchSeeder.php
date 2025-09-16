<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;
use Illuminate\Support\Facades\Schema;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Branch::truncate();
        Schema::enableForeignKeyConstraints();
        
        Branch::create(['name' => 'Sucursal Principal - Centro']);
    }
}