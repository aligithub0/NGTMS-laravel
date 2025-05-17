<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'logs',
        'ip_address',
    ];

    protected $casts = [
        'logs' => 'array',
    ];

    public function ticket()
    {
        return $this->belongsTo(Tickets::class, 'ticket_id');
    }
}
