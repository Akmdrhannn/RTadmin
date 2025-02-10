<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER after_penghuni_update
            AFTER UPDATE ON penghuni
            FOR EACH ROW
            BEGIN
                IF NEW.status_penghuni IN ("kontrak", "tetap") THEN
                    INSERT INTO historypenghuni (rumah_id, penghuni_id, tanggal_masuk)
                    VALUES (NEW.rumah_id, NEW.id_penghuni, NOW());
                END IF;

                IF NEW.status_penghuni = "Kosong" THEN
                    UPDATE historypenghuni
                    SET tanggal_keluar = NOW()
                    WHERE penghuni_id = OLD.id_penghuni AND tanggal_keluar IS NULL;
                END IF;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_penghuni_update');
    }
};
