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
            $table->unsignedInteger('type_id');
            $table->string('number', 30);
            $table->decimal('weight');
            $table->string('package_number', 30);
            $table->date('arrival_date')->nullable();
            $table->unsignedBigInteger('transporter_id')->nullable();

            $table->index('number');

            $table->timestamps();

            $table->foreign('folder_id')->references('id')->on('folders')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('type_id')->references('id')->on('container_types');
            $table->foreign('transporter_id')->references('id')->on('transporters');
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
