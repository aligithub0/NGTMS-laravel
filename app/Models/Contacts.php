<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'status',
        'contact_type_id',
        'designation_id',
        'preferred_contact_method',
        'contact_priority',
        'time_zone',
        'is_active',
        'picture_url',
        'country',
        'contact_segmentation_id',
    ];


    public function contactType()
    {
        return $this->belongsTo(ContactType::class, 'contact_type_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designations::class, 'designation_id');
    }

    public function contactSegmentation()
    {
        return $this->belongsTo(ContactSegmentation::class, 'contact_segmentation_id');
    }

}
