<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogTrait;
class Userstaff extends Model
{
    use LogTrait, HasFactory;

    protected $table="user_staf";
    protected $fillable=
    [
        'name',
        'username',
        'kode',
        'email',
        'password',
        'utype',
        'kondisi'

    ];
}
