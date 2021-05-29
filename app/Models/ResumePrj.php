<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class ResumePrj extends Model
{
    public function getDurationAttribute()
    {
        if ($this->is_not_end) {
            $duration = sprintf('%s-至今', $this->start_at_show);
        } else {
            $duration = sprintf('%s-%s', $this->start_at_show, $this->end_at_show);
        }

        return $duration;
    }

    public function getStartAtShowAttribute()
    {
        return date('Y.m', strtotime($this->start_at));
    }

    public function getEndAtShowAttribute()
    {
        return date('Y.m', strtotime($this->end_at));
    }

    public function getLongAttribute()
    {
        $start = new DateTime($this->start_at);
        $end =  $this->is_not_end ? new DateTime() : new DateTime($this->end_at);

        $diff = $start->diff($end);
        $diff_year = $diff->format('%y');
        $diff_month = $diff->format('%m');

        $long = $diff_year > 0 ? sprintf('%s年%s个月', $diff_year, $diff_month) : sprintf('%s个月', $diff_month);

        return $long;
    }
}
