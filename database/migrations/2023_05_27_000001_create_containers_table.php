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
        Schema::create('containers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('folder_id');
            $table->string('number', 30)->unique();
            $table->text('designation')->nullable();
            $table->decimal('weight');
            $table->string('package_number', 30);
            $table->date('filling_date');
            $table->date('arrival_date')->nullable();

            $table->index('number');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('containers');
    }
};
