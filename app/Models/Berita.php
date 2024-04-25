<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogTrait;
class Berita extends Model
{
    use LogTrait, HasFactory;
    protected $connection = 'mysql2';
    protected $table='personal_berita';
}
