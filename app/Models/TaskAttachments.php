<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskAttachments extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'file_url',
        'uploaded_by',
    ];


    public function tasks()
    {
        return $this->belongsTo(Tasks::class, 'task_id');
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
