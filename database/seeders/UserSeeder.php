<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        User::create(['name' => 'Cliente Prueba','document_number' => '123456789','email' => 'cliente@prueba.com','password' => Hash::make('password'),'role' => 'client',]);
        User::create(['name' => 'Cajero Prueba','document_number' => '987654321','email' => 'cajero@prueba.com','password' => Hash::make('password'),'role' => 'cashier',]);
        User::create(['name' => 'Admin Prueba','document_number' => '111222333','email' => 'admin@prueba.com','password' => Hash::make('password'),'role' => 'admin',]);
    }
}