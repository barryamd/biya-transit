<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transporters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('numberplate', 20)->unique();
            $table->string('marque', 20);
            $table->string('driver_name', 100);
            $table->string('driver_phone', 20);

            $table->index('numberplate');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transporters');
    }
};
