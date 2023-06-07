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
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('folder_id');
            $table->string('invoice_number', 30)->unique();
            $table->enum('type', ['DVT', 'DDI', 'PDT', 'TM', 'CT']);
            $table->integer('amount');
            $table->string('attach_file_path')->nullable();

            $table->index('invoice_number');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
