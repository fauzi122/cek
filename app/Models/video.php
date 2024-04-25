<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogTrait;
class video extends Model
{
   use LogTrait, HasFactory;

   protected $guarded=[];
}
