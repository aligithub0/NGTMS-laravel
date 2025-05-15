<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    protected $fillable = ['ticket_id', 'task_id','user_id','comment_type', 'comment'];


    public function tickets()
    {
        return $this->belongsTo(Tickets::class, 'ticket_id');
    }

    public function tasks()
    {
        return $this->belongsTo(Tasks::class, 'task_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
