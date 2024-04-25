<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogTrait;

class Komentar_mhs extends Model
{
    use LogTrait, HasFactory;

    protected $table='komentar_mhs';
    protected $guarded=[];
}
