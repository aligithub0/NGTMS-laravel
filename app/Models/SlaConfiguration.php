<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlaConfiguration extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'label', 'description', 'department_id', 'response_time', 'resolution_time', 'escalated_to_user_id', 'is_default'];


    public function department()
{
    return $this->belongsTo(Department::class, 'department_id');
}

// In each model
public static function getDefault()
{
    return self::where('is_default', true)->first();
}




public function escalated()
{
    return $this->belongsTo(User::class, 'escalated_to_user_id');
}

}
