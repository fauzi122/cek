<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogTrait;

class SettingPerakitSoal extends Model
{
    use HasFactory;
    use LogTrait;
	protected $guarded = [];
	protected $table='ujian_setting_perakits';
}
