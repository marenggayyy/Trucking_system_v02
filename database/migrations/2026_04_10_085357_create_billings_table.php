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
        Schema::create('billings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('trip_id')->constrained()->cascadeOnDelete();

            $table->string('client_name');

            // 💰 SNAPSHOT FROM DESTINATION RATE
            $table->decimal('rate', 10, 2);
            $table->decimal('amount', 10, 2);

            // 🧾 CHECK DETAILS
            $table->string('bank_name')->nullable();
            $table->string('check_number')->nullable();
            $table->date('check_release_date')->nullable();

            $table->enum('status', ['unbilled', 'pending', 'billed'])->default('unbilled');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billings');
    }
};
