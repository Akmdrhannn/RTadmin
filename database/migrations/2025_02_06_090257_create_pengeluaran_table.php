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
        Schema::create('pengeluaran', function (Blueprint $table) {
            $table->id('id_pengeluaran');
            $table->enum('kategori', ['Perbaikan jalan', 'Perbaikan selokan', 'Token listrik pos', 'Gaji satpam', 'Lain-lain']);
            $table->text('deskripsi');
            $table->date('tanggal_pengeluaran');
            $table->decimal('jumlah', 10, 2);
            $table->string('penerima');
            $table->string('bukti_pengeluaran');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaran');
    }
};
