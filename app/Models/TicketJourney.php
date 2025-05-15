<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


class TicketJourney extends Model
{
    use HasFactory;

    protected $fillable = ['ticket_id', 'from_agent','to_agent','from_status', 'to_status', 'actioned_by', 'logged_time', 'total_time_diff'];

    protected static function booted()
{
    static::creating(function ($journey) {
        // Find the last journey record for this ticket
        $lastJourney = self::where('ticket_id', $journey->ticket_id)
            ->latest('logged_time')
            ->first();

        if ($lastJourney) {
            $previousTime = Carbon::parse($lastJourney->logged_time);
            $currentTime = Carbon::parse($journey->logged_time ?? now());

            $journey->total_time_diff = $previousTime->diffInSeconds($currentTime); // Store in seconds
        } else {
            $journey->total_time_diff = 0; // First record for the ticket
        }

        // Ensure logged_time is set
        if (!$journey->logged_time) {
            $journey->logged_time = now();
        }
    });
}

    public function ticket()
    {
        return $this->belongsTo(Tickets::class, 'ticket_id');
    }

    public function fromAgent()
    {
        return $this->belongsTo(User::class, 'from_agent');
    }

    public function toAgent()
    {
        return $this->belongsTo(User::class, 'to_agent');
    }

    public function fromStatus()
    {
        return $this->belongsTo(TicketStatus::class, 'from_status');
    }

    public function toStatus()
    {
        return $this->belongsTo(TicketStatus::class, 'to_status');
    }

    public function actionedBy()
    {
        return $this->belongsTo(User::class, 'actioned_by');
    }
}
