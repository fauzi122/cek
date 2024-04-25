<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogTrait;

class Panitia_ujian extends Model
{
    use LogTrait, HasFactory;
    protected $guarded = [];
    // use SoftDeletes;
}
