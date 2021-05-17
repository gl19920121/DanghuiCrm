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

    public function getNoAttribute()
    {
        return sprintf('PN%s', str_pad($this->attributes['id'], 8, "0", STR_PAD_LEFT));
    }

    public function getNatureAttribute()
    {
        $nature = $this->attributes['nature'];

        switch ($nature) {
            case 'full':
                $nature = '全职';
                break;
            case 'part':
                $nature = '兼职';
                break;
            case 'all':
                $nature = '全职/兼职';
                break;

            default:
                break;
        }

        return $nature;
    }

    public function getWelfareAttribute()
    {
        $welfare = $this->attributes['welfare'];

        switch ($welfare) {
            case 'social_insurance':
                $welfare = '社会保险';
                break;
            case 'five_social_insurance_and_one_housing_fund':
                $welfare = '五险一金';
                break;
            case 'four_social_insurance_and_one_housing_fund':
                $welfare = '四险一金';
                break;

            default:
                break;
        }

        return $welfare;
    }

    public function getChannelArrAttribute()
    {
        $channelArr = [
            'applets' => ['show' => '小程序', 'selected' => true, 'default' => false],
            'website' => ['show' => '官网', 'selected' => true, 'default' => false],
            'other_platform' => ['show' => '其他', 'selected' => false, 'default' => false]
        ];

        return $channelArr;
    }
}
