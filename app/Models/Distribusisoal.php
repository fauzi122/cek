<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
// use App\Traits\LogTrait;
class Distribusisoal extends Model
{
  // use LogTrait;

  protected $guarded = [];
  public function soal()
  {
  	return $this->belongsTo('App\Models\Soal', 'id_soal');
  }
  public function kelas()
  {
  	return $this->belongsTo('App\Models\Kelas', 'id_kelas');
  }
  public function jawabUser()
  {
  	return $this->belongsTo('App\Models\Jawab', 'id_soal', 'id_soal'); //->where('id_user', Auth::user()->id);
  }
}
