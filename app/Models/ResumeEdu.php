<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResumeEdu extends Model
{
    protected $fillable = [];
    protected $guarded = [];

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
        if ($this->is_not_end) {
            $duration = sprintf('%s-至今', $this->start_at_show);
        } else {
            $duration = sprintf('%s-%s', $this->start_at_show, $this->end_at_show);
        }

        return $duration;
    }

    public function getSchoolLevelShowAttribute()
    {
        return Job::educationArr[$this->school_level]['text'];
    }
}
