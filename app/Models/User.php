<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'picture',
        'status_id',
        'password',
        'role_id',
        'department_id',
        'manager_id',
        'max_ticket_threshold',
        'emp_no',
        'emp_ref_no',
        'company_id',
        'designation_id',
        'user_type_id',
        'is_first_time',
        'assigned_to_others',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
{
    return $this->belongsTo(Role::class);
}

public function department()
{
    return $this->belongsTo(Department::class);
}

public function hasRole($roleName): bool
{
    return $this->role->name === $roleName;
}

public function manager()
{
    return $this->belongsTo(User::class, 'manager_id');
}

public function status()
{
    return $this->belongsTo(UserStatus::class, 'status_id');
}

// In User model
public function assignedTickets()
{
    return $this->hasMany(Tickets::class, 'assigned_to');
}

public function createdTickets()
{
    return $this->hasMany(Tickets::class, 'created_by');
}


// Get all users who report to this manager (direct reports)
public function agents()
{
    return $this->hasMany(User::class, 'manager_id');
}

// Check if this user is a manager (has agents)
public function isManager(): bool
{
    return $this->agents()->exists();
}

// Get all tickets assigned to this manager's agents
public function teamTickets()
{
    $agentIds = $this->agents()->pluck('id');
    return Tickets::whereIn('assigned_to', $agentIds);
}

public function designation()
{
    return $this->belongsTo(Designations::class, 'designation_id');
}

public function company()
{
    return $this->belongsTo(Company::class, 'company_id');
}

public function userType()
{
    return $this->belongsTo(UserType::class, 'user_type_id');
}

protected static function booted()
{
    static::saving(function ($user) {
        if ($user->company_id && $user->emp_ref_no) {
            $company = \App\Models\Company::find($user->company_id);
            if ($company && $company->company_code) {  
                $user->emp_no = $company->company_code . '-' . $user->emp_ref_no;
            }
        }
    });
}

// In User model
public function scopeActive($query)
{
    return $query->whereHas('status', function($query) {
        $query->where('name', 'Active');
    });
}

// In App\Models\User
public static function getAssignableUsers(): \Illuminate\Support\Collection
{
    $authUser = auth()->user();
    
    $query = self::where('company_id', $authUser->company_id)
        ->where('department_id', $authUser->department_id)
        ->where('assigned_to_others', true)
        ->whereHas('status', fn($q) => $q->where('name', 'Active'))
        ->orderBy('name');
    
    // Include current user if they can be assigned
    if ($authUser->assigned_to_others) {
        $query->orWhere('id', $authUser->id);
    }
    
    return $query->get()->mapWithKeys(fn($user) => [
        $user->id => $user->id === $authUser->id 
            ? $user->name . ' (Me)' 
            : $user->name
    ]);
}

}
