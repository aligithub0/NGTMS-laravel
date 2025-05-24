<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusWorkflow extends Model
{
    use HasFactory;
    
    protected $fillable = ['from_status_id', 'to_status_id', 'is_default'];


    public function fromStatus()
    {
        return $this->belongsTo(TicketStatus::class, 'from_status_id');
    }

    public function toStatus()
    {
        return $this->belongsTo(TicketStatus::class, 'to_status_id');
    }
}
