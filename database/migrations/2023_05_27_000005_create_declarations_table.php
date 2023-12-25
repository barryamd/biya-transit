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
        Schema::create('declarations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('folder_id');
            $table->string('number', 30)->unique();
            $table->date('date');
            $table->string('destination_office');
            $table->string('verifier', 30);
            $table->string('declaration_file_path')->nullable();
            $table->string('liquidation_bulletin', 20)->nullable();
            $table->date('liquidation_date')->nullable();
            $table->string('liquidation_file_path')->nullable();
            $table->string('receipt_number', 30)->nullable();
            $table->date('receipt_date')->nullable();
            $table->string('receipt_file_path')->nullable();
            $table->string('bon_number', 30)->nullable();
            $table->date('bon_date')->nullable();
            $table->string('bon_file_path')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->index('number');
            $table->index('liquidation_bulletin');
            $table->index('receipt_number');

            $table->timestamps();

            $table->foreign('folder_id')->references('id')->on('folders')
                ->onUpdate('CASCADE')->onDelete('CASCADE');

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
        Schema::dropIfExists('declarations');
    }
};
