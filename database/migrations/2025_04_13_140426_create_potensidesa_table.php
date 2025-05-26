<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('potensi_desas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_potensi');
            $table->string('kategori');
            $table->string('deskripsi')->nullable();
            $table->text('detail')->nullable();
            $table->string('gambar')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('potensi_desas');
    }
};