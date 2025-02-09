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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->date('bulan_tahun');
            $table->decimal('iuran_kebersihan', 10, 2);
            $table->integer('qty');
            $table->date('pembayaran_terakhir');
            $table->date('tanggal_pembayaran')->nullable();
            $table->decimal('total_pembayaran', 10, 2);
            $table->date('berlaku_sampai');
            $table->enum('status_pembayaran_kebersihan', ['Lunas', 'Belum lunas']);
            $table->decimal('iuran_satpam', 10, 2);
            $table->integer('qty1');
            $table->date('pembayaran_terakhir1');
            $table->date('tanggal_pembayaran1')->nullable();
            $table->decimal('total_pembayaran1', 10, 2);
            $table->date('berlaku_sampai1');
            $table->enum('status_pembayaran_satpam', ['Lunas', 'Belum lunas']);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
