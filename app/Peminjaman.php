<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    public $table = 'peminjaman';

    protected $fillable = [
        'nama',
        'email',
        'barang_pinjam',
        'tanggal_pinjam',
        'tanggal_kembali',
        'photo_path',
        'user_id'
    ];
}
