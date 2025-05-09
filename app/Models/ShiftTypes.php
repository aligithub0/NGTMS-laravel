<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftTypes extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status', 'from_time', 'to_time'];

}
