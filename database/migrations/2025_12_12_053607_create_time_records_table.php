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
        Schema::create('time_records', function (Blueprint $table) {
            $table->id();
            
            // --- CORE TRACKING FIELDS ---
            // Links the record to the employee who created it
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            
            // The time the employee started work (REQUIRED)
            $table->dateTime('clock_in'); 
            
            // The time the employee ended work (NULLABLE until they clock out)
            $table->dateTime('clock_out')->nullable(); 
            
            // Calculated total hours worked (NULLABLE until clock_out is recorded)
            $table->float('hours_worked', 8, 2)->nullable(); 
            // -----------------------------
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_records');
    }
};