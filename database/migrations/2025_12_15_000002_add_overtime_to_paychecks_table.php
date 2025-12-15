<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('paychecks', function (Blueprint $table) {
            $table->decimal('regular_hours', 8, 2)->default(0)->after('net_pay');
            $table->decimal('overtime_hours', 8, 2)->default(0)->after('regular_hours');
            $table->decimal('regular_pay', 10, 2)->default(0)->after('overtime_hours');
            $table->decimal('overtime_pay', 10, 2)->default(0)->after('regular_pay');
        });
    }

    public function down(): void
    {
        Schema::table('paychecks', function (Blueprint $table) {
            $table->dropColumn(['regular_hours', 'overtime_hours', 'regular_pay', 'overtime_pay']);
        });
    }
};
