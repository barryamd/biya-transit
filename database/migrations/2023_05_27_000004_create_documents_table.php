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
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('folder_id');
            $table->unsignedInteger('type_id');
            $table->string('number', 30);
            $table->string('attach_file_path')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->index('number');

            $table->timestamps();

            $table->foreign('folder_id')->references('id')->on('folders')
                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->foreign('type_id')->references('id')->on('document_types');

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
};
