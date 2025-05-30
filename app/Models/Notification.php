<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'ticket_id',
        'reply_id',
        'subject',
        'body_text',
        'body_html',
        'delivery_channel',
        'to_emails',
        'cc_emails',
        'bcc_emails',
        'to_numbers',
        'media_urls',
        'meta',
        'scheduled_at',
        'sent_at',
        'status',
        'retry_count',
        'priority',
        'message_id',
        'parent_message_id',
        'response_data',
        'notifiable_type',
        'notifiable_id',
        'read_at',
        'data'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'to_emails' => 'array',
        'cc_emails' => 'array',
        'bcc_emails' => 'array',
        'to_numbers' => 'array',
        'media_urls' => 'array',
        'meta' => 'array',
        'response_data' => 'array',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'read_at' => 'datetime',
        'data' => 'array'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'scheduled_at',
        'sent_at',
        'read_at'
    ];

    /**
     * Get the notifiable entity that the notification belongs to.
     */
    public function notifiable()
    {
        return $this->morphTo();
    }

    /**
     * Get the ticket associated with the notification.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Get the reply associated with the notification.
     */
    public function reply()
    {
        return $this->belongsTo(Reply::class);
    }
}