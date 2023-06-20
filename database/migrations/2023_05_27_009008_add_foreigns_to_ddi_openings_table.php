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
        Schema::table('ddi_openings', function (Blueprint $table) {
            $table
                ->foreign('folder_id')
                ->references('id')
                ->on('folders')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ddi_openings', function (Blueprint $table) {
            $table->dropForeign(['folder_id']);
        });
    }
};
