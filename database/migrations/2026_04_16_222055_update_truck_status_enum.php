<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement("
        ALTER TABLE trucks
        MODIFY status ENUM('available','on_trip','on_maintenance','unavailable') NOT NULL
    ");
    }

    public function down()
    {
        DB::statement("
        ALTER TABLE trucks
        MODIFY status ENUM('active','inactive','on_trip') NOT NULL
    ");
    }
};
