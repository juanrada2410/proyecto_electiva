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
        Schema::create('turns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            
            $table->string('turn_code')->unique(); // ej. C-001
            $table->integer('turn_number'); // ej. 1, 2, 3...
            
            // CORRECCIÓN AQUÍ:
            // Definimos 'status' como un ENUM, que solo acepta los valores de la lista.
            // Por defecto, cada nuevo turno será 'pending'.
            $table->enum('status', ['pending', 'attending', 'finished', 'cancelled'])->default('pending');

            $table->timestamp('called_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turns');
    }
};