<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Traits\LogTrait;


class SettingUjian extends Model
{
	use LogTrait;
	protected $guarded = [];
	protected $table='ujian_settings';

	
}
