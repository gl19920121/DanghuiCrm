<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Resume extends Model
{
    protected $fillable = [];
    protected $guarded = [];

    public const workYearsArr = [
        '1' => ['text' => '学生在读'],
        '2' => ['text' => '应届毕业生']
    ];

    public const educationArr = [
        'high_schoo' => ['text' => '高中'],
        'junior' => ['text' => '专科'],
        'undergraduate' => ['text' => '本科'],
        'master' => ['text' => '硕士'],
        'doctor' => ['text' => '博士']
    ];

    public const natureArr = [
        'full' => ['text' => '全职'],
        'part' => ['text' => '兼职'],
        'all' => ['text' => '全职/兼职']
    ];

    public const jobhunterStatusArr = [
        '0' => ['text' => '在职-暂不考虑'],
        '1' => ['text' => '在职-考虑机会'],
        '2' => ['text' => '在职-月内到岗'],
        '3' => ['text' => '离职-随时到岗']
    ];

    public const sourceArr = [
        'applets' => ['text' => '小程序', 'checked' => 'checked'],
        'website' => ['text' => '官网', 'checked' => 'checked'],
        'other_platform' => ['text' => '其他', 'has_remark' => true]
    ];

    public const updateDateArr = [
        '1' => ['text' => '最近三天'],
        '2' => ['text' => '最近一周'],
        '3' => ['text' => '最近两周'],
        '4' => ['text' => '最近一个月'],
        '5' => ['text' => '一个月以上']
    ];

    protected $casts = [
        'location' => 'array',
        'cur_industry' => 'array',
        'cur_position' => 'array',
        'exp_industry' => 'array',
        'exp_position' => 'array',
        'exp_location' => 'array',
        'source' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'upload_uid')->where('upload_uid', Auth::user()->id);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->wherePivot('user_id', Auth::user()->id);
    }

    public function usersSeen()
    {
        return $this->belongsToMany(User::class)->wherePivot('user_id', Auth::user()->id)->wherePivot('type', 'seen')->withTimestamps();
    }

    public function usersCollect()
    {
        return $this->belongsToMany(User::class)->wherePivot('user_id', Auth::user()->id)->wherePivot('type', 'collect')->withTimestamps();
    }

    public function usersRelay()
    {
        return $this->belongsToMany(User::class)->wherePivot('user_id', Auth::user()->id)->wherePivot('type', 'relay');
    }

    public function job()
    {
        return $this->belongsTo(Job::class)->where('execute_uid', Auth::user()->id);
    }

    public function resumeWorks()
    {
        return $this->hasMany(ResumeWork::class);
    }

    public function resumePrjs()
    {
        return $this->hasMany(ResumePrj::class);
    }

    public function resumeEdus()
    {
        return $this->hasMany(ResumeEdu::class);
    }

    public function getNoAttribute()
    {
        return sprintf('RE%s', str_pad($this->attributes['id'], 8, "0", STR_PAD_LEFT));
    }

    public function getStatusAttribute()
    {
        $status = $this->attributes['status'];

        switch ($status) {
            case -1:
                $status = '——';
                break;
            case 1:
                $status = '等待';
                break;

            default:
                break;
        }

        return $status;
    }

    public function getLocationDefaultAttribute()
    {
        return ['province' => '', 'city' => '', 'district' => ''];
    }

    public function getLocationAttribute()
    {
        return !empty($this->attributes['location']) ? json_decode($this->attributes['location'], true) : $this->location_default;
    }

    public function getLocationShowAttribute()
    {
        return !empty($this->attributes['location']) ? $this->location['city'] : '其他';
    }

    public function getExpLocationShowAttribute()
    {
        return isset($this->exp_location['city']) ? $this->exp_location['city'] : '其他';
    }

    public function getEducationShowAttribute()
    {
        return !empty($this->education) ? self::educationArr[$this->education]['text'] : '其他';
    }

    public function getExpWorkNatureShowAttribute()
    {
        return !empty($this->exp_work_nature) ? self::natureArr[$this->exp_work_nature]['text'] : '其他';
    }

    public function getCurPositionShowAttribute()
    {
        return isset($this->cur_position['rd']) ? $this->cur_position['rd'] : '其他';
    }

    public function getExpPositionShowAttribute()
    {
        return isset($this->exp_position['rd']) ? $this->exp_position['rd'] : '其他';
    }

    public function getCurIndustryShowAttribute()
    {
        return isset($this->cur_industry['th']) ? $this->cur_industry['th'] : '其他';
    }

    public function getExpIndustryShowAttribute()
    {
        return isset($this->exp_industry['th']) ? $this->exp_industry['th'] : '其他';
    }

    public function getCurPositionAttribute()
    {
        return !empty($this->cur_position) ? $this->cur_position : ['st' => '', 'nd' => '', 'rd' => ''];
    }

    public function getExpPositionAttribute()
    {
        return !empty($this->exp_position) ? $this->exp_position : ['st' => '', 'nd' => '', 'rd' => ''];
    }

    public function getCurIndustryAttribute()
    {
        return !empty($this->cur_industry) ? $this->cur_industry : ['st' => '', 'nd' => '', 'rd' => '', 'th' => ''];
    }

    public function getExpIndustryAttribute()
    {
        return !empty($this->exp_industry) ? $this->exp_industry : ['st' => '', 'nd' => '', 'rd' => '', 'th' => ''];
    }

    public function getWorkYearsArrAttribute()
    {
        $workYearsArr = self::workYearsArr;

        foreach ($workYearsArr as $key => $value) {
            if ($key === $this->work_years_flag) {
                $workYearsArr[$key]['checked'] = 'checked';
            } else {
                $workYearsArr[$key]['checked'] = '';
            }
        }

        return $workYearsArr;
    }

    public function getWorkYearsShowAttribute()
    {
        $workYears = $this->attributes['work_years'];
        $workYearsFlag = $this->attributes['work_years_flag'];

        if (isset(self::workYearsArr[$workYearsFlag])) {
            $workYears = self::workYearsArr[$workYearsFlag]['text'];
        } else {
            $workYears = sprintf('%s年', $workYears);
        }

        return $workYears;
    }

    public function getWorkYearsShowLongAttribute()
    {
        $workYears = $this->attributes['work_years'];
        $workYearsFlag = $this->attributes['work_years_flag'];

        if (isset(self::workYearsArr[$workYearsFlag])) {
            $workYears = self::workYearsArr[$workYearsFlag]['text'];
        } else {
            $workYears = sprintf('%s年工作经验', $workYears);
        }

        return $workYears;
    }

    public function getWorkYearsShowListAttribute()
    {
        $workYears = $this->attributes['work_years'];
        $workYearsFlag = $this->attributes['work_years_flag'];

        if (isset(self::workYearsArr[$workYearsFlag])) {
            $workYears = self::workYearsArr[$workYearsFlag]['text'];
        } else {
            $workYears = sprintf('工作%s年', $workYears);
        }

        return $workYears;
    }

    public function getEducationArrAttribute()
    {
        $educationArr = self::educationArr;

        foreach ($educationArr as $key => $value) {
            if ($key === $this->attributes['education']) {
                $educationArr[$key]['selected'] = 'selected';
            } else {
                $educationArr[$key]['selected'] = '';
            }
        }

        return $educationArr;
    }

    public function getExpWorkNatureArrAttribute()
    {
        $natureArr = self::natureArr;

        foreach ($natureArr as $key => $value) {
            if ($key === $this->exp_work_nature) {
                $natureArr[$key]['selected'] = 'selected';
            } else {
                $natureArr[$key]['selected'] = '';
            }
        }

        return $natureArr;
    }

    public function getJobhunterStatusShowAttribute()
    {
        if (isset(self::jobhunterStatusArr[$this->attributes['jobhunter_status']])) {
            $jobhunterStatus = self::jobhunterStatusArr[$this->attributes['jobhunter_status']]['text'];
        } else {
            $jobhunterStatus = '-';
        }

        return $jobhunterStatus;
    }

    public function getSourceArrAttribute()
    {
        $sourceArr = self::sourceArr;

        foreach ($sourceArr as $key => $value) {
            if (in_array($key, $this->source)) {
                $sourceArr[$key]['checked'] = 'checked';
            } else {
                $sourceArr[$key]['checked'] = '';
            }
        }

        return $sourceArr;
    }

    public function getSourceShowAttribute()
    {
        $source = $this->source;

        foreach ($source as $index => $value) {
            $source[$index] = $this->sourceArr[$value]['text'];
            if (isset($this->sourceArr[$value]['has_remark']) && $this->sourceArr[$value]['has_remark']) {
                $source[$index] .= sprintf('（%s）', $this->attributes['source_remarks']);
            }
        }

        return implode('/', $source);
    }

    public function getExpSalaryShowAttribute()
    {
        if ($this->exp_salary_flag === 0) {
            $expSalary = sprintf('%dK-%dK.%d薪', $this->exp_salary_min, $this->exp_salary_max, $this->exp_salary_count);
        } else {
            $expSalary = '面议';
        }

        return $expSalary;
    }

    public function getCurSalaryShowAttribute()
    {
        return sprintf('%dK.%d薪', $this->cur_salary, $this->cur_salary_count);
    }

    public function getCurSalaryShowLongAttribute()
    {
        return sprintf('%dK * %d月', $this->cur_salary, $this->cur_salary_count);
    }
}
