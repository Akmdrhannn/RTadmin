<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class historyPenghuni extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'historypenghuni';
    protected $primaryKey = 'id_history_penghuni';
    protected $fillable = [
        'id_history_penghuni',
        'rumah_id',
        'penghuni_id',
        'tanggal_masuk',
        'tanggal_keluar'
    ];
    protected $keyType = 'string';

    public function rumah(): BelongsTo
    {
        return $this->belongsTo(rumah::class);
    }

    public function penghuni(): BelongsTo
    {
        return $this->belongsTo(penghuni::class);
    }
}
