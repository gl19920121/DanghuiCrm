<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Services\FormateHelper;
use DateTime;

class ResumePrj extends Model
{
    protected $fillable = [];
    protected $guarded = [];
    protected $casts = [
        'is_not_end' => 'boolean'
    ];

    private $default = [
        'name' => '无',
        'role' => '无',
        'body' => '无',
        'duration' => '无',
        'long' => '无',
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

    public function getNameDefaultAttribute()
    {
        return $this->default['name'];
    }

    public function getRoleDefaultAttribute()
    {
        return $this->default['role'];
    }

    public function getBodyDefaultAttribute()
    {
        return $this->default['body'];
    }

    public function getDurationDefaultAttribute()
    {
        return $this->default['duration'];
    }

    public function getLongDefaultAttribute()
    {
        return $this->default['long'];
    }



    public function getNameShowAttribute()
    {
        return !empty($this->name) ? $this->name : $this->name_default;
    }

    public function getRoleShowAttribute()
    {
        return !empty($this->role) ? $this->role : $this->role_default;
    }

    public function getBodyShowAttribute()
    {
        return !empty($this->body) ? $this->body : $this->body_default;
    }



    public function getStartAtShowAttribute()
    {
        return date('Y.m', strtotime($this->start_at));
    }

    public function getEndAtShowAttribute()
    {
        return date('Y.m', strtotime($this->end_at));
    }

    public function getDurationAttribute()
    {
        if (empty($this->start_at) || (empty($this->end_at) || $this->is_not_end === 0)) {
            return $this->duration_default;
        }

        if ($this->is_not_end) {
            $duration = sprintf('%s-至今', $this->start_at_show);
        } else {
            $duration = sprintf('%s-%s', $this->start_at_show, $this->end_at_show);
        }

        return $duration;
    }

    public function getLongAttribute()
    {
        if (empty($this->start_at) || (empty($this->end_at) || $this->is_not_end === 0)) {
            return $this->long_default;
        }

        $start = new DateTime($this->start_at);
        $end =  $this->is_not_end ? new DateTime() : new DateTime($this->end_at);

        $diff = $start->diff($end);
        $diff_year = $diff->format('%y');
        $diff_month = $diff->format('%m');

        $long = $diff_year > 0 ? sprintf('%s年%s个月', $diff_year, $diff_month) : sprintf('%s个月', $diff_month);

        return $long;
    }
}
