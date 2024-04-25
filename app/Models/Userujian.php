<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userujian extends Model
{
    protected $table="user_ujian";
    protected $fillable=
    [
        'name',
        'username',
        'kode',
        'email',
        'password',
        'utype',
        'kondisi'

    ];
}
