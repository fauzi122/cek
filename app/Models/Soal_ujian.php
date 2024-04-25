<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogTrait;

class Soal_ujian extends Model
{
  use LogTrait;
  protected $primaryKey = null;
  protected $guarded = [];
  protected $table = "uts_soals";
}
