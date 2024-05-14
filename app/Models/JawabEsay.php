<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogTrait;

class JawabEsay extends Model
{
    use LogTrait;
    protected $table = 'ujian_jawab_esays';
    protected $guarded = [];
}
