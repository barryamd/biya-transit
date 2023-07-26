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
        Schema::create('folders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id');
            $table->enum('type', ['IMPORT', 'EXPORT']);
            $table->string('number', 30)->unique();
            $table->string('num_cnt', 30);
            $table->string('harbor', 30);
            $table->string('country', 30);
            $table->text('observation')->nullable();
            $table->enum('status', ['En attente', 'En cours', 'Fermé'])
                ->default('En attente');

            $table->index('number');

            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('folders');
    }
};
