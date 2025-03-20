<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_project',
        'client',
        'nilai_project',
        'tanggal_mulai',
        'deadline',
        'status',
        'keterangan'
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function getTotalDibayarAttribute()
    {
        return $this->transaksi->where('jenis', 'pemasukan')->sum('jumlah');
    }

    public function getSisaPembayaranAttribute()
    {
        return $this->nilai_project - $this->total_dibayar;
    }
}
