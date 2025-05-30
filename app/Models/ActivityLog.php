<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

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

     public static function createLogEntry(string $action, ?int $ticketId = null, array $data = [])
    {
        $user = auth()->user();
        
        return static::create([
            'ticket_id' => $ticketId,
            'logs' => [
                'user_id' => $user?->id,
                'user_name' => $user?->name ?? 'System',
                'action' => $action,
                'data' => $data,
                'ip_address' => Request::ip(),
                'timestamp' => now()->toDateTimeString(),
            ],
            'ip_address' => Request::ip(),
        ]);
    }
}
