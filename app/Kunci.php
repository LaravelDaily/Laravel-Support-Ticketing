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
}
