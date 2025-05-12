<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesMenu extends Model
{
    use HasFactory;

    protected $fillable = ['role_id', 'menu_id', 'status'];

    protected $casts = [
        'menu_id' => 'array',
    ];

    public function roles()
{
    return $this->belongsTo(User::class, 'role_id');
}

public function menus()
{
    return $this->belongsToMany(Meneus::class, 'roles_menus', 'id', 'menu_id')
        ->withPivot('role_id', 'status');
}
}
