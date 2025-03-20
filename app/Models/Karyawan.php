<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';

    protected $fillable = [
        'nama',
        'posisi',
        'email',
        'no_telepon',
        'tanggal_bergabung',
        'gaji_pokok',
        'status'
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function gajiHistory()
    {
        return $this->transaksi->where('kategori', 'gaji');
    }
}
