<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogTrait;
class Absen_praktisi extends Model
{
    use LogTrait, HasFactory;
    protected $table = 'absen_praktisi';
    protected $guarded = [];
}
