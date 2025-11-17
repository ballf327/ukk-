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
            $table->string('status', 50)->default('baik')->comment('baik, rusak, cacat');
            $table->text('deskripsi_masalah')->nullable()->comment('Penjelasan masalah/kerusakan');
            $table->string('foto_masalah')->nullable()->comment('Foto kerusakan/masalah');
            $table->string('keterangan', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temporary_item', function (Blueprint $table) {
            $table->dropColumn(['status', 'deskripsi_masalah', 'foto_masalah', 'keterangan']);
        });
    }
};
