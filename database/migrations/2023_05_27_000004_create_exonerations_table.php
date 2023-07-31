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
        Schema::create('exonerations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('folder_id');
            $table->unsignedBigInteger('container_id')->nullable();
            $table->string('number', 30);
            $table->date('date');
            $table->string('responsible');
            $table->string('attach_file_path')->nullable();

            $table->timestamps();

            $table->foreign('folder_id')->references('id')->on('folders')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('container_id')->references('id')->on('containers')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exonerations');
    }
};
