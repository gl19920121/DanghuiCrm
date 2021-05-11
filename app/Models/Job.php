<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [];

    protected $guarded = [];

    public function resumes()
    {
        return $this->hasMany(Resume::class);
    }

    public function setStatusAttribute($value)
    {
        $status = $value;
        switch ($status) {
            case 'ing':
                $status = 1;
                break;
            case 'pause':
                $status = 2;
                break;
            case 'end':
                $status = 3;
                break;
            default:
                $status = 1;
                break;
        }
        $this->attributes['status'] = $status;
    }

    public function getTypeAttribute()
    {
        return json_decode($this->attributes['type']);
    }

    public function getLocationAttribute()
    {
        return json_decode($this->attributes['location']);
    }

    public function getCityAttribute()
    {
        $location = $this->getLocationAttribute();
        return $location->city;
    }
}
