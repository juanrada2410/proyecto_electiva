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
        // Le decimos a Laravel que llame a los otros seeders en este orden
        $this->call([
            UserSeeder::class,
            BranchSeeder::class,
            ServiceSeeder::class,
        ]);
    }
}

