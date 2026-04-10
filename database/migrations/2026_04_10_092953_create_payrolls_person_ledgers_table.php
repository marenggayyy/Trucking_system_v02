<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payroll_person_ledgers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('payroll_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();

            // 💰 EARNINGS
            $table->decimal('total_earnings', 10, 2)->default(0);

            // ➕ ADDITIONS
            $table->decimal('allowance', 10, 2)->default(0);

            // 💵 FINAL
            $table->decimal('net_pay', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_person_ledgers');
    }
};
