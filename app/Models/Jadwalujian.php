<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogTrait;

class Jadwal extends Model
{
    use LogTrait, HasFactory;
    protected $table='jadwal';
}
