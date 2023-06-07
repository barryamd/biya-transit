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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('folder_id');
            $table->unsignedBigInteger('transporter_id');
            $table->date('delivery_date');
            $table->string('delivery_place');
            $table->boolean('delivery_status')->default(0);
            $table->boolean('customer_satisfaction')->nullable();
            $table->string('attach_file_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
