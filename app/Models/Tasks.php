<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'ticket_id',
        'title',
        'description',
        'assigned_to',
        'status',
        'due_date',
    ];


    public function projects()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function tickets()
    {
        return $this->belongsTo(Tickets::class, 'ticket_id');
    }

    public function AssignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
