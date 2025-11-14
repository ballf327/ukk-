<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('temporary_item', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['id_item']);
            
            // Make id_item nullable
            $table->unsignedBigInteger('id_item')->nullable()->change();
            
            // Re-add foreign key with nullable support
            $table->foreign('id_item')->references('id_item')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temporary_item', function (Blueprint $table) {
            $table->dropForeign(['id_item']);
            $table->unsignedBigInteger('id_item')->change();
            $table->foreign('id_item')->references('id_item')->on('items')->onDelete('cascade');
        });
    }
};
