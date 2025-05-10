<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesMenu extends Model
{
    use HasFactory;

    protected $fillable = ['role_id', 'menu_id', 'status'];

    protected $casts = [
        'role_id' => 'array',
        'menu_id' => 'array',
    ];

public function roles()
{
    return $this->belongsToMany(Role::class, 'roles_menus', 'id', 'role_id')
        ->withPivot('menu_id', 'status');
}

public function menus()
{
    return $this->belongsToMany(Meneus::class, 'roles_menus', 'id', 'menu_id')
        ->withPivot('role_id', 'status');
}
}
