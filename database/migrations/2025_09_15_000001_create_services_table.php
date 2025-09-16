<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // AÑADIMOS LA COLUMNA DIRECTAMENTE AQUÍ
            $table->boolean('is_active')->default(true); 
            $table->string('prefix', 3)->unique(); // El prefijo para el código de turno, ej: 'C' para Caja
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};