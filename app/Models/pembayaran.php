<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class pembayaran extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_transaksi';
    protected $fillable = [
        'id_transaksi',
        'userid',
        'penghuni_id',
        'bulan_tahun',
        'iuran_kebersihan',
        'qty',
        'pembayaran_terakhir',
        'tanggal_pembayaran',
        'total_pembayaran',
        'berlaku_sampai',
        'status_pembayaran_kebersihan',
        'iuran_satpam',
        'qty1',
        'pembayaran_terakhir1',
        'tanggal_pembayaran1',
        'total_pembayaran1',
        'berlaku_sampai1',
        'status_pembayaran_satpam'
    ];
    protected $keyType = 'string';

    public function penghuni(): BelongsTo
    {
        return $this->belongsTo(penghuni::class);
    }

    public function user(): HasMany
    {
        return $this->hasMany(user::class);
    }
}
