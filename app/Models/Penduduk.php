<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penduduk extends Model
{
    use HasFactory;

    protected $table = 'penduduks';
    protected $fillable = [
        'nama',
        'nik',
        'tgl_lahir',
        'jns_kelamin',
        'alamat',
        'provinsi_id',
        'kabupaten_id',
    ];

    public function kabupaten(): BelongsTo
    {
        return $this->belongsTo(Kabupaten::class);
    }

    public function provinsi(): BelongsTo
    {
        return $this->belongsTo(Provinsi::class);
    }
}
