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
        Schema::create('potensi_areas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kategori');
            $table->text('deskripsi')->nullable();
            $table->decimal('latitude', 10, 8); // Tambahkan kolom latitude
            $table->decimal('longitude', 11, 8); // Tambahkan kolom longitude
            $table->json('polygon')->nullable(); // Simpan koordinat sebagai array JSON
            $table->string('foto')->nullable(); // Tambahkan kolom untuk menyimpan path foto
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('potensi_areas');
    }
};
