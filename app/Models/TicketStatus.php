<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Tickets;

class TicketStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'is_default'
    ];
    
     public function tickets(): HasMany
    {
        return $this->hasMany(Tickets::class, 'ticket_status_id');
    }


    // In each model
        public static function getDefault()
        {
            return self::where('is_default', true)->first();
        }
}
