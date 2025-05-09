<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_comp_id','is_group','company_code', 'company_type_id', 'status'];

    public function company()
{
    return $this->belongsTo(Company::class, 'parent_comp_id');
}

public function companies()
{
    return $this->belongsTo(CompanyTypes::class, 'company_type_id');
}

}
