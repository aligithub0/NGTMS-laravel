<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Tickets extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'title',
        'description',
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
    ];
 
    protected $casts = [
        'purpose_type_id' => 'array',
        'notification_type_id' => 'array',
    ];
 
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
}
