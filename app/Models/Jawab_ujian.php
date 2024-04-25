<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogTrait;

class Jawab extends Model
{
  use LogTrait;

  public function user()
  {
    return $this->belongsTo('App\User', 'id_user');
  }
  public function detailSoal()
  {
    return $this->belongsTo('App\Models\Detailsoal', 'no_soal_id');
  }
}
