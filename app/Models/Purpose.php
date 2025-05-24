<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purpose extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id', 'sla_id', 'description', 'status', 'is_default'];

    public function parent()
    {
        return $this->belongsTo(Purpose::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Purpose::class, 'parent_id');
    }

    public function sla()
    {
        return $this->belongsTo(SlaConfiguration::class, 'sla_id');
    }

    // In each model
    public static function getDefault()
    {
        return self::where('is_default', true)->first();
    }
}
