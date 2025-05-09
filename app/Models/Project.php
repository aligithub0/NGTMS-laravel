<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status', 'project_type_id', 'company_id', 'start_date', 'end_date', 'project_owner_id'];

        public function project_type()
        {
            return $this->belongsTo(ProjectTypes::class, 'project_type_id');
        }

        public function company()
        {
            return $this->belongsTo(Company::class, 'company_id');
        }

        public function project_owner()
        {
            return $this->belongsTo(User::class, 'project_type_id');
        }

}
