<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactsPreferences extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'whatsapp_pref',
        'mailing_address_pref',
        'language_pref',
        'email_opt_in',
        'whatsapp_opt_in',
    ];

    public function contact()
    {
        return $this->belongsTo(Contacts::class, 'contact_id');
    }
}
