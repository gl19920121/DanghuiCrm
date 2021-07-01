<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Services\FormateHelper;

class ResumeEdu extends Model
{
    protected $fillable = [];
    protected $guarded = [];
    protected $casts = [
        'is_not_end' => 'boolean'
    ];

    private $default = [
        'major' => '其他',
        'duration' => '其他',
    ];



    public function setStartAtAttribute($value)
    {
        $this->attributes['start_at'] = FormateHelper::date($value, 'year');
    }

    public function setEndAtAttribute($value)
    {
        $this->attributes['end_at'] = FormateHelper::date($value, 'year');
    }



    public function getStartAtMonthAttribute()
    {
        return isset($this->attributes['start_at']) ? FormateHelper::date($this->attributes['start_at']) : '';
    }

    public function getEndAtMonthAttribute()
    {
        return isset($this->attributes['end_at']) ? FormateHelper::date($this->attributes['end_at']) : '';
    }



    public function getMajorDefaultAttribute()
    {
        return $this->default['major'];
    }

    public function getDurationDefaultAttribute()
    {
        return $this->default['duration'];
    }



    public function getMajorShowAttribute()
    {
        return !empty($this->major) ? $this->major : $this->major_default;
    }

    public function getDurationShowAttribute()
    {
        return !empty($this->duration) ? $this->duration : $this->duration_default;
    }



    public function getStartAtShowAttribute()
    {
        return date('Y.m.d', strtotime($this->start_at));
    }

    public function getEndAtShowAttribute()
    {
        return date('Y.m.d', strtotime($this->end_at));
    }

    public function getDurationAttribute()
    {
        if (empty($this->start_at) || (empty($this->end_at) || $this->is_not_end === 0)) {
            return $this->duration_default;
        }

        if ($this->is_not_end === 1) {
            $duration = sprintf('%s-至今', $this->start_at_show);
        } else {
            $duration = sprintf('%s-%s', $this->start_at_show, $this->end_at_show);
        }

        return $duration;
    }

    public function getSchoolLevelShowAttribute()
    {
        return trans('db.education')[$this->school_level];
    }
}
