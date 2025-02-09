<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class pengeluaran extends Model
{
    use SoftDeletes, HasFactory;
    protected $table = 'pengeluaran';
    protected $primaryKey = 'id_pengeluaran';
    protected $fillable = [
        'id_pengeluaran',
        'userid',
        'kategori',
        'deskripsi',
        'tanggal_pengeluaran',
        'jumlah',
        'penerima',
        'bukti_pengeluaran'
    ];

    protected $keyType = 'string';

    protected function buktitrx(): Attribute
    {
        return Attribute::make(
            get: fn($bukti) => url('storage/buktitrx/' . $bukti)
        );
    }

    public function user(): BelongsTo
    {
        return $this->BelongsTo(user::class);
    }
}
