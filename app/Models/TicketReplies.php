<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketReplies extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'replied_by_user_id',
        'subject',
        'message',
        'priority_type_id',
        'reply_type',
        'attachment_path',
        'internal_notes',
        'external_notes',
        'is_desc_send_to_contact',
        'status_after_reply',
        'contact_id',
        'contact_ref_no',
        'contact_email',
        'to_recipients',
        'cc_recipients',
        'is_reply_from_contact',
        'is_contact_notify',
        'activity_log',
        'attachment_path',
        'is_read',
        'parent_reply_id',
        'parent_message_id',
        'message_id',
        'scheduled_at',
        'is_scheduled'
    ];

    protected $casts = [
        'to_recipients' => 'array',
        'cc_recipients' => 'array',
        'attachment_path' => 'array',
        'scheduled_at' => 'datetime',
        'is_scheduled' => 'boolean'
    ];



    public function ticket()
    {
        return $this->belongsTo(Tickets::class, 'ticket_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'replied_by_user_id');
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class, 'priority_type_id');
    }

    public function replyType()
    {
        return $this->belongsTo(TicketSource::class, 'reply_type');
    }

    public function ticketStatus()
    {
        return $this->belongsTo(TicketStatus::class, 'status_after_reply');
    }

}
