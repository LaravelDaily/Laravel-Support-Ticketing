<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunci extends Model
{
    use HasFactory;

    protected $table = 'kunci';

    protected $fillable = [
        'kunci'
    ];

    /**
     * Get the user that owns the phone.
     */
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }
}
