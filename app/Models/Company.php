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

    public const natureArr = [
        'foreign' => ['text' => '外商独资/外企办事处', 'selected' => 'selected'],
        'joint_venture' => ['text' => '中外合营(合资/合作)'],
        'private' => ['text' => '私营/民营企业'],
        'state' => ['text' => '国有企业'],
        'listed' => ['text' => '国内上市公司'],
        'government' => ['text' => '政府机关／非盈利机构'],
        'institution' => ['text' => '事业单位'],
        'other' => ['text' => '其他']
    ];

    public const scaleArr = [
        ['text' => '1-49人'],
        ['text' => '50-99人'],
        ['text' => '100-499人'],
        ['text' => '500-999人'],
        ['text' => '1000-2000人'],
        ['text' => '2000-5000人'],
        ['text' => '5000-10000人'],
        ['text' => '10000人以上']
    ];

    public const investmentArr = [
        'angel' => ['text' => '天使轮', 'selected' => 'selected'],
        'round_a' => ['text' => 'A轮'],
        'round_b' => ['text' => 'B轮'],
        'round_c' => ['text' => 'C轮'],
        'round_d_and_above' => ['text' => 'D轮及以上'],
        'fuk' => ['text' => '已上市'],
        'strategic' => ['text' => '战略融资'],
        'undisclosed' => ['text' => '融资未公开'],
        'not_needed' => ['text' => '不需要融资'],
        'other' => ['text' => '其他']
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
        if (isset(self::natureArr[$this->attributes['nature']])) {
            return self::natureArr[$this->attributes['nature']]['text'];
        } else {
            return '无';
        }
    }

    public function getScaleShowAttribute()
    {
        if (isset(self::scaleArr[$this->attributes['scale']])) {
            return self::scaleArr[$this->attributes['scale']]['text'];
        } else {
            return '无';
        }
    }

    public function getInvestmentShowAttribute()
    {
        return self::investmentArr[$this->attributes['investment']]['text'];
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
