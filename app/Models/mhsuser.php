<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class mhsuser extends Model
{
    use HasFactory;
    use Notifiable;
    use HasApiTokens;
    protected $guarded = [];
}
