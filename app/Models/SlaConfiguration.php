<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlaConfiguration extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'department_id', 'purpose_id', 'response_time', 'resolution_time', 'escalated_to_user_id', 'is_default'];


    public function department()
{
    return $this->belongsTo(Department::class, 'department_id');
}

public function purpose()
{
    return $this->belongsTo(Purpose::class, 'purpose_id');
}


public function escalated()
{
    return $this->belongsTo(User::class, 'escalated_to_user_id');
}

}
