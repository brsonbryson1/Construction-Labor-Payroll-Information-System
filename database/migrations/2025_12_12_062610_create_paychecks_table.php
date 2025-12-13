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
        Schema::create('paychecks', function (Blueprint $table) {
            $table->id();
            
            // 1. Relationship to the User who received the paycheck
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // 2. Pay Period Dates
            $table->date('pay_period_start');
            $table->date('pay_period_end');
            
            // 3. Payment Date (when the paycheck was issued)
            $table->date('pay_date');
            
            // 4. Financial Amounts
            $table->decimal('gross_pay', 10, 2);
            $table->decimal('net_pay', 10, 2);
            $table->decimal('total_deductions', 10, 2)->default(0.00);

            // 5. Status and Document Path
            $table->string('status')->default('Paid'); // e.g., Paid, Pending, Processed
            $table->string('file_path')->nullable(); // Path to the downloadable pay stub (e.g., PDF)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paychecks');
    }
};