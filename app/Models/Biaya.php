<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Biaya extends Model
{
    use HasFactory;

    protected $table = 'biaya';

    protected $fillable = [
        'nama_biaya',
        'jenis',
        'periode',
        'jumlah',
        'tanggal_mulai',
        'tanggal_selesai',
        'status_aktif',
        'keterangan'
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'status_aktif' => 'boolean'
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}
