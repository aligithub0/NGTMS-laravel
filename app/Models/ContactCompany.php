<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactCompany extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_comp_id','is_group', 'status'];

    public function parentCompany()
    {
        return $this->belongsTo(ContactCompany::class, 'parent_comp_id');
    }

}
