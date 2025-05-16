<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactsPhoneNumbers extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'phone_type',
        'phone_number',
        'is_whatsapp',
        'is_preferred',
    ];

    public function contact()
    {
        return $this->belongsTo(Contacts::class, 'contact_id');
    }
}
