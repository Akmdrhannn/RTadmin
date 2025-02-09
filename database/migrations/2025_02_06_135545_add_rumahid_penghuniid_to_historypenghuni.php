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
        Schema::table('historypenghuni', function (Blueprint $table) {
            $table->bigInteger('rumah_id')->after('id_history_penghuni')->unsigned();
            $table->bigInteger('penghuni_id')->after('rumah_id')->unsigned();
            $table->foreign('rumah_id')->references('id_rumah')->on('rumah')->onDelete('cascade');
            $table->foreign('penghuni_id')->references('id_penghuni')->on('penghuni')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historypenghuni', function (Blueprint $table) {
            //
        });
    }
};
