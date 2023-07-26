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
        Schema::create('delivery_notes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('folder_id');
            $table->unsignedBigInteger('container_id')->nullable();
            $table->string('bcm');
            $table->string('bct');
            $table->string('bcm_file_path')->nullable();
            $table->string('bct_file_path')->nullable();
            $table->timestamps();

            $table->foreign('folder_id')->references('id')->on('folders')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('container_id')->references('id')->on('containers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_notes');
    }
};
