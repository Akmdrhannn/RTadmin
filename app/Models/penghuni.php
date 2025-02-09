<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class penghuni extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'penghuni';
    protected $primaryKey = 'id_penghuni';
    protected $fillable = [
        'id_penghuni',
        'nama_lengkap',
        'foto_ktp',
        'status_penghuni',
        'nomor_telp',
        'status_menikah',
        'rumah_id'
    ];
    protected $keyType = 'string';

    protected function ftktp(): Attribute
    {
        return Attribute::make(
            get: fn($foto) => url('/storage/fotoktp/' . $foto)
        );
    }

    public function rumah(): BelongsTo
    {
        return $this->belongsTo(rumah::class);
    }

    public function historyPenghuni(): HasMany
    {
        return $this->hasMany(historyPenghuni::class);
    }

    public function pembayaran(): HasMany
    {
        return $this->hasMany(pembayaran::class);
    }
}
