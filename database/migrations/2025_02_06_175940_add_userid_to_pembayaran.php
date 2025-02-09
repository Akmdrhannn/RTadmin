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
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->bigInteger('userid')->after('id_transaksi')->unsigned();
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('penghuni_id')->after('userid')->unsigned();
            $table->foreign('penghuni_id')->references('id_penghuni')->on('penghuni')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            //
        });
    }
};
