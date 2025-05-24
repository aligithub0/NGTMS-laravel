<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Tickets extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'title',
        'ticket_status_id',
        'created_by_id',
        'assigned_to_id',
        'ticket_source_id',
        'contact_id',
        'contact_ref_no',
        'purpose_type_id',
        'SLA',
        'resolution_time_id',
        'response_time_id',
        'response_time',
        'resolution_time_id',
        'response_time_id',
        'response_time',
        'resolution_time',
        'notification_type_id',
        'company_id',
        'reminder_flag',
        'reminder_datetime',
        'internal_note',
        'external_note',
        'priority_id',
        'message',
        'requested_email',
        'to_recipients',
        'cc_recipients',
        'ticket_id',
        'is_read',
    ];
 
    protected $casts = [
        'purpose_type_id' => 'array',
        'notification_type_id' => 'array',
        'to_recipients' => 'array',
        'cc_recipients' => 'array',
    ];


    protected static function booted()
    {

        static::created(function ($ticket) {
            TicketJourney::create([
                'ticket_id' => $ticket->id,
                'from_agent' => null,
                'to_agent' => $ticket->assigned_to_id,
                'from_status' => null,
                'to_status' => $ticket->ticket_status_id,
                'actioned_by' => auth()->id(),
                'logged_time' => now(),
            ]);
        });
        
        static::updating(function ($ticket) {
            $original = $ticket->getOriginal();
            
            if ($original['ticket_status_id'] != $ticket->ticket_status_id || 
                $original['assigned_to_id'] != $ticket->assigned_to_id) {
                
                TicketJourney::create([
                    'ticket_id' => $ticket->id,
                    'from_agent' => $original['assigned_to_id'],
                    'to_agent' => $ticket->assigned_to_id,
                    'from_status' => $original['ticket_status_id'],
                    'to_status' => $ticket->ticket_status_id,
                    'actioned_by' => auth()->id(),
                    'logged_time' => now(),
                    'total_time_diff'=> now()
                ]);
            }
        });
    }

        protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            $ticket->ticket_id = self::generateTicketId();
        });
    }

    public static function generateTicketId()
    {
        do {
            $id = 'TCKT-' . strtoupper(uniqid());
        } while (self::where('ticket_id', $id)->exists());

        return $id;
    }

 
    public function ticketStatus()
    {
        return $this->belongsTo(TicketStatus::class, 'ticket_status_id');
    }
 
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
 
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }
 
    public function ticketSource()
    {
        return $this->belongsTo(TicketSource::class, 'ticket_source_id');
    }

    public function contacts()
    {
        return $this->belongsTo(Contacts::class, 'contact_id');
    }
 
    public function purposeTypes()
    {
        return Purpose::whereIn('id', $this->purpose_type_id ?? [])->get();
    }
 
    public function slaConfiguration()
    {
        return $this->belongsTo(SlaConfiguration::class, 'SLA');
    }
 
    public function notificationType()
    {
        return NotificationType::whereIn('id', $this->notification_type_id ?? [])->get();
    }
 
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function responseTime()
    {
        return $this->belongsTo(SlaConfiguration::class, 'response_time_id');
    }

    public function resolutionTime()
    {
        return $this->belongsTo(SlaConfiguration::class, 'resolution_time_id');
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class, 'priority_id');
    }

   
    // public function replies()
    // {
    //     return $this->hasMany(TicketReplies::class)->orderBy('created_at', 'desc');
    // }

    public function replies()
{
    return $this->hasMany(TicketReplies::class, 'ticket_id');
}


public function assignedUser()
{
    return $this->belongsTo(User::class, 'assigned_to_id'); 
}

}
