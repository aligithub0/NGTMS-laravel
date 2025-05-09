<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesMenu extends Model
{
    use HasFactory;

    protected $fillable = ['role_id', 'menu_id', 'status'];


    public function roles()
{
    return $this->belongsTo(User::class, 'role_id');
}

public function menues()
{
    return $this->belongsTo(Meneus::class, 'menu_id');
}
}
