<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Traits\LogTrait;


class Soal extends Model
{
  use LogTrait;
  protected $guarded = [];

  public function dataDateri()
  {
    return $this->belongsTo('App\Models\Materi', 'materi');
  }
  public function user()
  {
    return $this->belongsTo('App\User', 'id_user');
  }
  public function jawab()
  {
    return $this->belongsTo('App\Models\Jawab', 'id_soal');
  }
  public function detailSoal()
  {
    return $this->hasMany('App\Models\Detailsoal', 'id_soal');
  }

  public function detail_soal_essays()
  {
    return $this->hasMany(DetailSoalEssay::class, 'id_soal', 'id');
  }

  public function distribusi($where)
  {
     $dis = DB::table('distribusisoals')
    ->where($where);
    if($dis->count()>0){
      foreach($dis->get() as $i){
          $h[$i->id_kelas]=$i;
      }
      return $h;
    }
    else
    {
     return $dis->get();
    }
  }
  public function jml_soal() {
    $hasil = DB::table('detailsoals')
        ->select(DB::raw('id_soal, COUNT(*) as jumlah'))
        ->where('status', 'Y')
        ->groupBy('id_soal')
        ->pluck('jumlah', 'id_soal');

    return $hasil;
}

  

}
