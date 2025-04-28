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
        Schema::table('kategori', function (Blueprint $table) {
            //
        });

        Schema::table('potensi_desas', function (Blueprint $table) {
            // Add foreign key column
            $table->unsignedBigInteger('kategori_id')->nullable()->after('id');
            
            // Add foreign key constraint
            $table->foreign('kategori_id')
                  ->references('id')
                  ->on('kategori_potensi')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kategori', function (Blueprint $table) {
            //
        });

        Schema::table('potensi_desas', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['kategori_id']);
            
            // Then drop the column
            $table->dropColumn('kategori_id');
        });
    }
};
