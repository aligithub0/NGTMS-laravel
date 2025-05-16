<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'is_default'
    ];

    // In each model
public static function getDefault()
{
    return self::where('is_default', true)->first();
}
}
