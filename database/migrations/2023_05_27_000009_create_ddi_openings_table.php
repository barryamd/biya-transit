<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ddi_openings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('folder_id');
            $table->string('dvt_number', 30)->unique();
            $table->date('dvt_obtained_date');
            $table->string('ddi_number', 30)->unique();
            $table->date('ddi_obtained_date')->nullable();
            $table->string('attach_file_path')->nullable();

            $table->index('dvt_number');
            $table->index('ddi_number');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ddi_openings');
    }
};
