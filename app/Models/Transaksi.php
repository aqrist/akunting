<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'tanggal',
        'jenis', // pemasukan, pengeluaran
        'kategori', // dp_project, pelunasan_project, gaji, biaya_operasional, dll
        'jumlah',
        'keterangan',
        'project_id',
        'karyawan_id'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
