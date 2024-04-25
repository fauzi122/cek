<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogTrait;

class Info extends Model
{
    use LogTrait, HasFactory;
    protected $fillable=
    [
        'id',
        'title',
        'nip',
        'file'
       


    ];
}
