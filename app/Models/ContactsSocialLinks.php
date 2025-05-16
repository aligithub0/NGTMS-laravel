<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactsSocialLinks extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'platform',
        'handle',
    ];

    public function contact()
    {
        return $this->belongsTo(Contacts::class, 'contact_id');
    }
}
