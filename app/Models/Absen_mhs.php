<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogTrait;
class Absen_mhs extends Model
{
    use LogTrait, HasFactory;
    protected $fillable = ['nip', 'nim', 'status_hadir', 'kd_mtk', 'pertemuan'];
    protected $table = 'absen_mhs';
}
