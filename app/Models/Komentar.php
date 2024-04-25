<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogTrait;

class Komentar extends Model
{
    use LogTrait, HasFactory;

    protected $table='komentar_chat';
    protected $fillable=['id_chat','user_komentar','komentar'];
}
