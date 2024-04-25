<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogTrait;
class Agamakristen extends Model
{
    use LogTrait, HasFactory;
    protected $table="pertemuan_agama";
    protected $guarded=[];
    
}
