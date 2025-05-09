<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Timesheet extends Model
{
    use HasFactory;

    protected $fillable = ['ts_activity_id', 'activity_description', 'user_id', 'project_id', 'shift_type_id', 'ts_status_id', 'approved_by_id', 'approved_date', 'from_time', 'to_time', 'total_time_consumed'];



    public function TimesheetActivity()
{
    return $this->belongsTo(TimesheetActivities::class, 'ts_activity_id');
}

    public function users()
    {
       return $this->belongsTo(User::class, 'user_id');
    }
    
    public function project()
    {
       return $this->belongsTo(Project::class, 'project_id');
    }

    public function shift_type()
    {
       return $this->belongsTo(ShiftTypes::class, 'shift_type_id');
    }
    
    public function ts_status()
    {
       return $this->belongsTo(TimesheetStatus::class, 'ts_status_id');
    }

    public function approved_by()
    {
       return $this->belongsTo(User::class, 'approved_by_id');
    }

    protected static function booted()
    {
        static::saving(function ($timesheet) {
            if ($timesheet->from_time && $timesheet->to_time) {
                $start = Carbon::createFromFormat('H:i:s', $timesheet->from_time);
                $end = Carbon::createFromFormat('H:i:s', $timesheet->to_time);
    
                if ($end->lessThan($start)) {
                    $end->addDay(); // for overnight shifts
                }
    
                $diffInSeconds = $end->diffInSeconds($start);
    
                $hours = floor($diffInSeconds / 3600);
                $minutes = floor(($diffInSeconds % 3600) / 60);
    
                $timesheet->total_time_consumed = sprintf('%02d:%02d', $hours, $minutes);
            }
        });
    }
    
    

}
