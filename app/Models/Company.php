<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Company extends Model
{
    protected $fillable = [];

    protected $guarded = [];

    protected $casts = [
        'industry' => 'array',
        'location' => 'array'
    ];



    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function getNatureShowAttribute()
    {
        if (isset(trans('db.company.nature')[$this->attributes['nature']])) {
            return trans('db.company.nature')[$this->attributes['nature']];
        } else {
            return '无';
        }
    }

    public function getScaleShowAttribute()
    {
        if (isset(trans('db.company.scale')[$this->attributes['scale']])) {
            return trans('db.company.scale')[$this->attributes['scale']];
        } else {
            return '无';
        }
    }

    public function getInvestmentShowAttribute()
    {
        if (isset(trans('db.company.investment')[$this->attributes['investment']])) {
            return trans('db.company.investment')[$this->attributes['investment']];
        } else {
            return '无';
        }
    }

    public function getLocationAttribute()
    {
        return json_decode($this->attributes['location'], true);
    }

    public function getIndustryAttribute()
    {
        return json_decode($this->attributes['industry'], true);
    }

    public function getLocationShowAttribute()
    {
        $location = $this->location['province'];
        if (!empty($this->location['city'])) {
            $location .= sprintf('-%s', $this->location['city']);
        }
        if (!empty($this->location['district'])) {
            $location .= sprintf('-%s', $this->location['district']);
        }
        return $location;
        // return sprintf('%s-%s-%s', $this->location['province'], $this->location['city'], $this->location['district']);
    }

    public function getIndustryShowAttribute()
    {
        return empty($this->industry['th']) ? '无' : $this->industry['th'];
    }

    public function getLogoAttribute()
    {
        if (empty($this->attributes['logo'])) {
            return null;
        } else {
            return asset(Storage::disk('company_logo')->url($this->attributes['logo']));
        }
    }
}
