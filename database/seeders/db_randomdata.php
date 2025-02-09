<?php

namespace Database\Seeders;

use App\Models\penghuni;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class db_randomdata extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //Seed untuk user
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'ambatukam@gmail.com',
            'password' => Hash::make('ambatukam'),
        ]);

        //Seed untuk rumah
        for ($i = 1; $i <= 20; $i++) {
            DB::table('rumah')->insert([
                'alamat' => 'Blok Anggrek No. ' . $i,
                'status_rumah' => $i <= 15 ? 'Dihuni' : 'Tidak dihuni',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        //Seed penghuni
        $nama_penghuni = ['Siti Aminah', 'Budi Santoso', 'Agus Salim', 'Indra Kurniawan', 'Razman', 'Teguh Prasetyo', 'Anita Susanti', 'Lina Marlina', 'Rina Sari', 'Ratna Dewanti', 'Doni Saputra', 'Fajar Pradana', 'Tony Stark', 'Aditya Jaya', 'Kirasmokes'];

        for ($i = 0; $i < 15; $i++) {
            DB::table('penghuni')->insert([
                'nama_lengkap' => $nama_penghuni[$i],
                'foto_ktp' => 'ktp' . ($i + 1) . '.jpg',
                'status_penghuni' => $i < 15 ? 'Tetap' : 'Kontrak',
                'nomor_telp' => '081234567' . str_pad($i + 1, 2, '0', STR_PAD_LEFT),
                'status_menikah' => $i % 2 == 0 ? 'Menikah' : 'Belum Menikah',
                'rumah_id' => $i + 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null
            ]);
        }

        //Seed pengeluaran
        $kategori = ['Perbaikan jalan', 'Perbaikan selokan', 'Token listrik pos', 'Gaji satpam', 'Lain-lain'];

        for ($i = 0; $i < 15; $i++) {
            DB::table('pengeluaran')->insert([
                'userid' => 1,
                'kategori' => $kategori[array_rand($kategori)],
                'deskripsi' => '-',
                'tanggal_pengeluaran' => Carbon::now()->subDays(rand(1, 365)),
                'jumlah' => rand(100000, 1000000),
                'penerima' => 'vendor' . $i,
                'bukti_pengeluaran' => 'bukti' . $i . '.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }


        //Seed history penghuni
        for ($i = 1; $i <= 15; $i++) {
            DB::table('historypenghuni')->insert([
                'rumah_id' => $i,
                'penghuni_id' => $i,
                'tanggal_masuk' => Carbon::now()->subMonths(rand(6, 24)),
                'tanggal_keluar' => $i % 5 == 0 ? Carbon::now() : null,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        //Seed pembayaran
        for ($i = 1; $i <= 15; $i++) {
            $penghuni = penghuni::find($i);
            if ($penghuni) {
                $qty = rand(1, 12);
                $qty1 = rand(1, 12);

                $lastpay = now()->subMonth(rand(1, 12));
                $lastpay1 = now()->subMonth(rand(1, 12));

                $validUntil = $this->tanggalExpired($qty);
                $validUntil1 = $this->tanggalExpired($qty1);


                DB::table('pembayaran')->insert([
                    'userid' => 1,
                    'penghuni_id' => $penghuni->id_penghuni,
                    'bulan_tahun' => now(),
                    'iuran_kebersihan' => 15000,
                    'qty' => $qty,
                    'pembayaran_terakhir' => $lastpay,
                    'tanggal_pembayaran' => $tanggal_pembayaran = rand(0, 1) ? now() : null,
                    'total_pembayaran' => 15000 * $qty,
                    'berlaku_sampai' => $validUntil,
                    'status_pembayaran_kebersihan' => $tanggal_pembayaran ? 'Lunas' : 'Belum Lunas',
                    'iuran_satpam' => 100000,
                    'qty1' => $qty1,
                    'pembayaran_terakhir1' => $lastpay1,
                    'tanggal_pembayaran1' => $tanggal_pembayaran1 = rand(0, 1) ? now() : null,
                    'total_pembayaran1' => 100000 * $qty1,
                    'berlaku_sampai1' => $validUntil1,
                    'status_pembayaran_satpam' => $tanggal_pembayaran1 ?  'Lunas' : 'Belum Lunas',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null
                ]);
            }
        }
    }
    private function tanggalExpired($qty)
    {
        // Menggunakan tanggal pembayaran sekarang sebagai dasar
        $berlakuSampai = now()->addMonths($qty);

        return $berlakuSampai;
    }
}
