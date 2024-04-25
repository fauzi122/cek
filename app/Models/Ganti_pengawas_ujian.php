<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogTrait;

class Ganti_pengawas_ujian extends Model
{
    use LogTrait;
    use HasFactory;
    protected $guarded=[];
    protected $table='ganti_pengawas_ujians';
}
