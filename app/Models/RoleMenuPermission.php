<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleMenuPermission extends Model
{
    use HasFactory;

    protected $fillable = ['role_menu_id', 'objects', 'status', 'role_id'];

    protected $casts = [
        'objects' => 'array',
    ];

    public function rolesMenu()
{
    return $this->belongsTo(RolesMenu::class, 'role_menu_id');
}

public function roles()
{
    return $this->belongsTo(Role::class, 'role_id');
}

public function menus()
{
    return $this->belongsTo(Meneus::class, 'role_menu_id');
}


public function getMenuNamesAttribute()
{
    if (!$this->rolesMenu || empty($this->rolesMenu->menu_id)) {
        return null;
    }
    
    $menuIds = json_decode($this->rolesMenu->menu_id, true);
    return Meneus::whereIn('id', $menuIds)->pluck('name')->join(', ');
}
}
