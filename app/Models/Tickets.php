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
        'resolution_time',
        'response_time',
        'notification_type_id',
        'company_id',
        'reminder_flag',
        'reminder_datetime',
        'internal_note',
        'external_note',
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

    public function purposeType()
    {
        return $this->belongsTo(Purpose::class, 'purpose_type_id');
    }

    public function slaConfiguration()
    {
        return $this->belongsTo(SlaConfiguration::class, 'SLA');
    }

    public function notificationType()
    {
        return $this->belongsTo(NotificationType::class, 'notification_type_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
