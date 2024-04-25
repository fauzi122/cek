<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wa_status extends Model
{
    protected $table="wa_status";
    protected $fillable=
    [
        'status',
        'created_at',
        'updated_at'
        
    ];
}
