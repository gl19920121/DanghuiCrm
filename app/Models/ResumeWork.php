<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use App\Http\Services\FormateHelper;

class ResumeWork extends Model
{
    protected $fillable = [];
    protected $guarded = [];
    protected $casts = [
        'company_industry' => 'array',
        'job_type' => 'array',
        'is_not_end' => 'boolean',
        // 'start_at' => 'date:Y-m',
        // 'end_at' => 'date:Y-m',
        'salary' => 'double',
    ];

    private $arrFormat = [
        'company_industry' => ['st' => '', 'nd' => '', 'rd' => '', 'th' => ''],
        'job_type' => ['st' => '', 'nd' => '', 'rd' => ''],
    ];

    private $default = [
        'company_nature' => '其他',
        'company_scale' => '其他',
        'company_investment' => '其他',
        'company_industry' => '其他',
        'job_type' => '其他',
        'subordinates' => '无',
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

    public function getCompanyNatureDefaultAttribute()
    {
        return $this->default['company_nature'];
    }

    public function getCompanyScaleDefaultAttribute()
    {
        return $this->default['company_scale'];
    }

    public function getCompanyInvestmentDefaultAttribute()
    {
        return $this->default['company_investment'];
    }

    public function getCompanyIndustryDefaultAttribute()
    {
        return $this->default['company_industry'];
    }

    public function getJobTypeDefaultAttribute()
    {
        return $this->default['job_type'];
    }

    public function getSubordinatesDefaultAttribute()
    {
        return $this->default['subordinates'];
    }



    public function getCompanyIndustryAttribute()
    {
        return !empty($this->attributes['company_industry']) ? json_decode($this->attributes['company_industry'], true) : $this->arrFormat['company_industry'];
    }

    public function getJobTypeAttribute()
    {
        return !empty($this->attributes['job_type']) ? json_decode($this->attributes['job_type'], true) : $this->arrFormat['job_type'];
    }



    public function getSubordinatesShowAttribute()
    {
        return !empty($this->attributes['subordinates']) ? $this->attributes['subordinates'] : $this->subordinates_default;
    }

    public function getCompanyNatureShowAttribute()
    {
        return !empty($this->company_nature) ? trans('db.company.nature')[$this->company_nature] : $this->company_nature_default;
    }

    public function getCompanyScaleShowAttribute()
    {
        return !empty($this->company_scale) ? trans('db.company.scale')[$this->company_scale] : $this->company_scale_default;
    }

    public function getCompanyInvestmentShowAttribute()
    {
        return !empty($this->company_investment) ? trans('db.company.investment')[$this->company_investment] : $this->company_investment_default;
    }

    public function getCompanyIndustryShowAttribute()
    {
        return !empty($this->company_industry['th']) ? $this->company_industry['th'] : $this->company_industry_default;
    }

    public function getJobTypeShowAttribute()
    {
        return !empty($this->job_type['rd']) ? $this->job_type['rd'] : $this->job_type_default;
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

    public function getSalaryShowAttribute()
    {
        return sprintf('%sK.%d薪', $this->salary, $this->salary_count);
    }
}
