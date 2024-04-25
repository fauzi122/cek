<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Traits\LogTrait;

class Distribusisoal_ujian extends Model
{
  use LogTrait;
  
  protected $guarded = [];
  protected $table = 'ujian_distribusisoals';

  // public function soal()
  // {
  //   return $this->belongsTo('App\Models\Soal', 'id_soal');
  // }
  // public function kelas()
  // {
  //   return $this->belongsTo('App\Models\Kelas', 'id_kelas');
  // }
  // public function jawabUser()
  // {
  //   return $this->belongsTo('App\Models\Jawab', 'id_soal', 'id_soal'); //->where('id_user', Auth::user()->id);
  // }
}
