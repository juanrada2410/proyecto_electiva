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
            $table->string('turn_number');
            
            // Llaves foráneas (la forma correcta de relacionar tablas)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            $table->foreignId('assigned_cashier_id')->nullable()->constrained('users')->onDelete('set null');

            $table->enum('status', ['waiting', 'in_progress', 'completed', 'cancelled'])->default('waiting');
            
            $table->timestamp('request_date')->nullable();
            $table->timestamp('called_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            
            $table->timestamps();
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
