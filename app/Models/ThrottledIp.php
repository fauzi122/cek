<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThrottledIp extends Model
{
    protected $table = 'throttled_ips';
    protected $guarded = [];
}
