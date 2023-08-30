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
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name', 64);
            $table->string('last_name', 30)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place', 30)->nullable();
            $table->string('phone_number', 30)->nullable();
            $table->string('address')->nullable();
            $table->boolean('active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('active','first_name','last_name','birth_date','birth_place','phone_number','address');
        });
    }
};
