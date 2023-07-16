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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('acronym');
            $table->string('logo');
            $table->string('signature')->nullable();
            $table->string('email');
            $table->string('phone1', 25);
            $table->string('phone2', 25)->nullable();
            $table->string('phone3', 25)->nullable();
            $table->string('address')->nullable();
            $table->decimal('exchange_rate')->default(10500);
            $table->string('postcode')->nullable();
            $table->string('vat_no')->nullable();
            $table->string('nif')->nullable();
            $table->string('bank')->nullable();
            $table->string('bank_code')->nullable();
            $table->string('agency_code')->nullable();
            $table->string('account_number')->nullable();
            $table->string('cie')->nullable();
            $table->string('bank_address')->nullable();
            $table->string('bic')->nullable();  // le BIC pour les virements
            $table->string('iban')->nullable(); // l'IBAN pour les virements
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
        Schema::dropIfExists('settings');
    }
};
