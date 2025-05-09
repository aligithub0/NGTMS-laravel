<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentPurposes extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'purpose_id'];


    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function purpose()
{
    return $this->belongsTo(Purpose::class, 'purpose_id');
}
}
