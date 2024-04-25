<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertemuanSisfo extends Model
{
    protected $table='pertemuan';
    protected $guarded=[];
    protected $connection = 'sisfo.bsi';
}
