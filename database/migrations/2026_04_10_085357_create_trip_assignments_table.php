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
        Schema::create('trip_assignments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('trip_id')->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();

            $table->enum('role', ['driver', 'helper']);

            $table->decimal('rate_percentage', 5, 2);
            $table->decimal('earning', 10, 2)->default(0);

            // 🔥 IMPORTANT FOR PAYROLL
            $table->boolean('is_paid')->default(false);
            $table->foreignId('payrolls_id')->nullable()->constrained()->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_assignments');
    }
};
