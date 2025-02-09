<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rumah extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'rumah';
    protected $primaryKey = 'id_rumah';
    protected $fillable = [
        'id_rumah',
        'alamat',
        'status_rumah'
    ];
    protected $keyType = 'string';

    public function penghuni(): HasMany
    {
        return $this->hasMany(penghuni::class);
    }

    public function historyPenghuni(): HasMany
    {
        return $this->hasMany(historyPenghuni::class);
    }
}
