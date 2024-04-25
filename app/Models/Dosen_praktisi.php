<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogTrait;

class Dosen_praktisi extends Model
{
    use LogTrait, HasFactory;

    protected $table = 'dosen_praktisi';
    protected $guarded = [];
}
