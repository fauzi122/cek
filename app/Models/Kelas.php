<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogTrait;

class Kelas extends Model
{
  use LogTrait;

  protected $table = 'kelas';

  public function distribusisoal()
  {
    return $this->belongsTo('App\Models\Distribusisoal', 'id_kelas', 'id');
  }
  public function soal()
  {
    return $this->belongsTo('App\Models\Soal', 'id_user');
  }
  public function kelas()
  {
    return $this->belongsTo('App\Models\Kelas', 'id_kelas');
  }
  public function wali()
  {
    return $this->belongsTo('App\User', 'id_wali');
  }
  public function siswa()
  {
    return $this->hasMany(User::class, 'id_kelas', 'id')->where('status', 'S');
  }
}
