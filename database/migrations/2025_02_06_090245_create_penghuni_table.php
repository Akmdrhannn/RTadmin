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
        Schema::create('penghuni', function (Blueprint $table) {
            $table->id('id_penghuni');
            $table->string('nama_lengkap');
            $table->string('foto_ktp');
            $table->enum('status_penghuni', ['Kontrak', 'Tetap', 'Kosong']);
            $table->string('nomor_telp', length: 15);
            $table->enum('status_menikah', ['Menikah', 'Belum Menikah']);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penghuni');
    }
};
