<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Traits\LogTrait;


class Detailsoal extends Model
{
	use LogTrait;
	protected $guarded = [];

	public function checkJawab()
	{
		return $this->belongsTo('App\Models\Jawab', 'id', 'no_soal_id')->where('id_user', Auth::user()->username);
	}
	public function jmlJawab()
	{
		return $this->hasOne('App\Models\Jawab', 'id', 'no_soal_id')->where('id_user', Auth::user()->username);
	}
}
