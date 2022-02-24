<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Auth;

class Resume extends Model
{
    protected $fillable = [];

    protected $guarded = [];

    protected $casts = [
        'location' => 'array',
        'cur_industry' => 'array',
        'cur_position' => 'array',
        'exp_industry' => 'array',
        'exp_position' => 'array',
        'exp_location' => 'array',
        'source' => 'array',
        'is_not_end' => 'boolean',
        // 'exp_salary_min' => 'float',
        'cur_salary' => 'double',
        'exp_salary_min' => 'double',
        'exp_salary_max' => 'double',
        'upload_uid' => 'integer',
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

    public function usersAccept()
    {
        return $this->belongsToMany(User::class)->wherePivot('user_id', Auth::user()->id)->wherePivot('type', 'accept')->withTimestamps();
    }

    public function usersRelay()
    {
        return $this->belongsToMany(User::class)->wherePivot('user_id', Auth::user()->id)->wherePivot('type', 'relay')->withTimestamps();
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

    public function scopeStatus($query, $status)
    {
        $scope;

        if (is_numeric($status)) {
            $scope = $query->where('status', $status);
        } else {
            $tab = str_replace('resume_', '', $status);
            switch ($tab) {
                case 'untreated':
                    $scope = $query->whereIn('status', [-1, 1]);
                    break;
                case 'talking':
                    $scope = $query->where('status', 2);
                    break;
                case 'push_resume':
                    $scope = $query->where('status', 3);
                    break;
                case 'interview':
                    $scope = $query->where('status', 4);
                    break;
                case 'offer':
                    $scope = $query->where('status', 5);
                    break;
                case 'onboarding':
                    $scope = $query->where('status', 6);
                    break;
                case 'over_probation':
                    $scope = $query->where('status', 7);
                    break;
                case 'out':
                    $scope = $query->where('status', 0);
                    break;

                default:
                    $scope = $query->whereIn('status', [-1, 1]);
                    break;
            }
        }

        return $scope;
    }

    public function scopeActive($query)
    {
        return $query->whereNotIn('status', [-2, 0, 8]);
    }

    public function scopeUntreated()
    {
        return $query->whereIn('status', [-1, 1]);
    }

    public function scopeOut($query)
    {
        return $query->where('status', 0);
    }

    public function scopeNew($query)
    {
        return $query->where('status', 1);
    }

    public function scopeTalking($query)
    {
        return $query->where('status', 2);
    }

    public function scopePushResume($query)
    {
        return $query->where('status', 3);
    }

    public function scopeInterview($query)
    {
        return $query->where('status', 4);
    }

    public function scopeOffer($query)
    {
        return $query->where('status', 5);
    }

    public function scopeOnboarding($query)
    {
        return $query->where('status', 6);
    }

    public function scopeOverProbation($query)
    {
        return $query->where('status', 7);
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

    public function getDeliverAtAttribute()
    {
        $deliverAt = $this->attributes['deliver_at'];
        if (empty($deliverAt)) {
            $deliverAt = $this->updated_at;
        }
        return $deliverAt;
    }

    private $arrFormat = [
        'location' => ['province' => '', 'city' => '', 'district' => ''],
        'exp_location' => ['province' => '', 'city' => '', 'district' => ''],
        'cur_position' => ['st' => '', 'nd' => '', 'rd' => ''],
        'cur_industry' => ['st' => '', 'nd' => '', 'rd' => '', 'th' => ''],
        'exp_industry' => ['st' => '', 'nd' => '', 'rd' => '', 'th' => ''],
        'exp_position' =>  ['st' => '', 'nd' => '', 'rd' => ''],
    ];

    private $default = [
        'location' => '其他',
        'exp_location' => '其他',
        'cur_position' => '其他',
        'exp_position' => '其他',
        'cur_industry' => '其他',
        'exp_industry' => '其他',
        'wechat' => '无',
        'qq' => '无',
        'blacklist' => '无',
        'education' => '其他',
        'cur_company' => '无',
        'exp_work_nature' => '其他',
        'cur_salary' => 0,
        'cur_salary_count' => 12,
        'jobhunter_status' => '其他',
        'social_home' => '无',
        'personal_advantage' => '无',
        'remark' => '无',
    ];

    public function setCurPositionAttribute($data)
    {
        $curIndustry = is_array($data) ? $data : [
            'st' => $data,
            'nd' => $data,
            'rd' => $data,
            'th' => $data
        ];

        $this->attributes['cur_position'] = json_encode($curIndustry);
    }

    public function setCurIndustryAttribute($data)
    {

        $curIndustry = is_array($data) ? $data : [
            'st' => $data,
            'nd' => $data,
            'rd' => $data,
            'th' => $data
        ];

        $this->attributes['cur_industry'] = json_encode($curIndustry);
    }

    public function setEducationAttribute($data)
    {
        if (strpos($data, '高') !== false) {
            $education = 'high_schoo';
        } elseif (strpos($data, '专') !== false) {
            $education = 'junior';
        } elseif (strpos($data, '本') !== false) {
            $education = 'undergraduate';
        } elseif (strpos($data, '硕') !== false) {
            $education = 'master';
        } elseif (strpos($data, '博') !== false) {
            $education = 'doctor';
        } else {
            $education = $data;
        }

        $this->attributes['education'] = $education;
    }

    public function getLocationDefaultAttribute()
    {
        return $this->default['location'];
    }

    public function getExpLocationDefaultAttribute()
    {
        return $this->default['exp_location'];
    }

    public function getCurPositionDefaultAttribute()
    {
        return $this->default['cur_position'];
    }

    public function getExpPositionDefaultAttribute()
    {
        return $this->default['exp_position'];
    }

    public function getCurIndustryDefaultAttribute()
    {
        return $this->default['cur_industry'];
    }

    public function getExpIndustryDefaultAttribute()
    {
        return $this->default['exp_industry'];
    }

    public function getWechatDefaultAttribute()
    {
        return $this->default['wechat'];
    }

    public function getQqDefaultAttribute()
    {
        return $this->default['qq'];
    }

    public function getBlacklistDefaultAttribute()
    {
        return $this->default['blacklist'];
    }

    public function getEducationDefaultAttribute()
    {
        return $this->default['education'];
    }

    public function getCurCompanyDefaultAttribute()
    {
        return $this->default['cur_company'];
    }

    public function getExpWorkNatureDefaultAttribute()
    {
        return $this->default['exp_work_nature'];
    }

    public function getCurSalaryDefaultAttribute()
    {
        return $this->default['cur_salary'];
    }

    public function getCurSalaryCountDefaultAttribute()
    {
        return $this->default['cur_salary_count'];
    }

    public function getJobhunterStatusDefaultAttribute()
    {
        return $this->default['jobhunter_status'];
    }

    public function getSocialHomeDefaultAttribute()
    {
        return $this->default['social_home'];
    }

    public function getPersonalAdvantageDefaultAttribute()
    {
        return $this->default['personal_advantage'];
    }

    public function getRemarkDefaultAttribute()
    {
        return $this->default['remark'];
    }



    public function getLocationAttribute()
    {
        return !empty($this->attributes['location']) ? json_decode($this->attributes['location'], true) : $this->arrFormat['location'];
    }

    public function getExpLocationAttribute()
    {
        return !empty($this->attributes['exp_location']) ? json_decode($this->attributes['exp_location'], true) : $this->arrFormat['exp_location'];
    }

    public function getCurPositionAttribute()
    {
        return !empty($this->attributes['cur_position']) ? json_decode($this->attributes['cur_position'], true) : $this->arrFormat['cur_position'];
    }

    public function getExpPositionAttribute()
    {
        return !empty($this->attributes['exp_position']) ? json_decode($this->attributes['exp_position'], true) : $this->arrFormat['exp_position'];
    }

    public function getCurIndustryAttribute()
    {
        return !empty($this->attributes['cur_industry']) ? json_decode($this->attributes['cur_industry'], true) : $this->arrFormat['cur_industry'];
    }

    public function getExpIndustryAttribute()
    {
        return !empty($this->attributes['exp_industry']) ? json_decode($this->attributes['exp_industry'], true) : $this->arrFormat['exp_industry'];
    }



    public function getLocationShowAttribute()
    {
        return !empty($this->location['city']) ? $this->location['city'] : $this->location_default;
    }

    public function getExpLocationShowAttribute()
    {
        return !empty($this->exp_location['city']) ? $this->exp_location['city'] : $this->exp_location_default;
    }

    public function getCurPositionShowAttribute()
    {
        return !empty($this->cur_position['rd']) ? $this->cur_position['rd'] : $this->cur_position_default;
    }

    public function getExpPositionShowAttribute()
    {
        return !empty($this->exp_position['rd']) ? $this->exp_position['rd'] : $this->exp_position_default;
    }

    public function getCurIndustryShowAttribute()
    {
        return !empty($this->cur_industry['th']) ? $this->cur_industry['th'] : $this->cur_industry_default;
    }

    public function getExpIndustryShowAttribute()
    {
        return !empty($this->exp_industry['th']) ? $this->exp_industry['th'] : $this->exp_industry_default;
    }

    public function getEducationShowAttribute()
    {
        return !empty($this->education) ? trans('db.education')[$this->education] : $this->education_default;
    }

    public function getExpWorkNatureShowAttribute()
    {
        return !empty($this->exp_work_nature) ? trans('db.job.nature')[$this->exp_work_nature] : $this->exp_work_nature_default;
    }

    public function getWechatShowAttribute()
    {
        return !empty($this->wechat) ? $this->wechat : $this->wechat_default;
    }

    public function getQqShowAttribute()
    {
        return !empty($this->qq) ? $this->qq : $this->qq_default;
    }

    public function getBlacklistShowAttribute()
    {
        return !empty($this->blacklist) ? $this->blacklist : $this->blacklist_default;
    }

    public function getCurCompanyShowAttribute()
    {
        return !empty($this->cur_company) ? $this->cur_company : $this->cur_company_default;
    }

    public function getCurSalaryShowAttribute()
    {
        return !empty($this->cur_salary) ? $this->cur_salary : $this->cur_salary_default;
    }

    public function getCurSalaryCountShowAttribute()
    {
        return !empty($this->cur_salary_count) ? $this->cur_salary_count : $this->cur_salary_count_default;
    }

    public function getSocialHomeShowAttribute()
    {
        return !empty($this->social_home) ? $this->social_home : $this->social_home_default;
    }

    public function getPersonalAdvantageShowAttribute()
    {
        return !empty($this->personal_advantage) ? $this->personal_advantage : $this->personal_advantage_default;
    }

    public function getRemarkShowAttribute()
    {
        return !empty($this->remark) ? $this->remark : $this->remark_default;
    }



    public function getJobhunterStatusShowAttribute()
    {
        if (isset(trans('db.resume.jobhunter_status')[$this->attributes['jobhunter_status']])) {
            $jobhunterStatus = trans('db.resume.jobhunter_status')[$this->attributes['jobhunter_status']];
        } else {
            $jobhunterStatus = $this->jobhunter_status_default;
        }

        return $jobhunterStatus;
    }

    public function getWorkYearsShowAttribute()
    {
        $workYears = $this->attributes['work_years'];
        $workYearsFlag = $this->attributes['work_years_flag'];

        if (isset(trans('db.resume.work_years')[$workYearsFlag])) {
            $workYears = trans('db.resume.work_years')[$workYearsFlag];
        } else {
            $workYears = sprintf('%s年', $workYears);
        }

        return $workYears;
    }

    public function getWorkYearsShowLongAttribute()
    {
        $workYears = $this->attributes['work_years'];
        $workYearsFlag = $this->attributes['work_years_flag'];

        if (isset(trans('db.resume.work_years')[$workYearsFlag])) {
            $workYears = trans('db.resume.work_years')[$workYearsFlag];
        } else {
            $workYears = sprintf('%s年工作经验', $workYears);
        }

        return $workYears;
    }

    public function getWorkYearsShowListAttribute()
    {
        $workYears = $this->attributes['work_years'];
        $workYearsFlag = $this->attributes['work_years_flag'];

        if (isset(trans('db.resume.work_years')[$workYearsFlag])) {
            $workYears = trans('db.resume.work_years')[$workYearsFlag];
        } else {
            $workYears = sprintf('工作%s年', $workYears);
        }

        return $workYears;
    }

    public function getSourceShowAttribute()
    {
        $source = $this->source;

        foreach ($source as $index => $value) {
            if (!isset(trans('db.channel')[$value])) {
                continue;
            }
            $source[$index] = trans('db.channel')[$value];
            if (in_array($value, trans('db.channel_remark')) && !empty($this->attributes['source_remarks'])) {
                $sourceRemarks = $this->attributes['source_remarks'];
                if ( isset( trans('db.source_remarks')[$sourceRemarks] )) {
                    $remarks = trans('db.source_remarks')[$sourceRemarks];
                } else {
                    $remarks = $sourceRemarks;
                }
                $source[$index] .= sprintf('（%s）', $remarks);
            }
        }

        return implode('/', $source);
    }

    public function getExpSalaryShowAttribute()
    {
        if ($this->exp_salary_flag === 0) {
            $expSalary = sprintf('%sK-%sK.%d薪', $this->exp_salary_min, $this->exp_salary_max, $this->exp_salary_count);
        } else {
            $expSalary = '面议';
        }

        return $expSalary;
    }

    public function getCurSalaryShowShortAttribute()
    {
        return sprintf('%sK.%d薪', $this->cur_salary_show, $this->cur_salary_count_show);
    }

    public function getCurSalaryShowLongAttribute()
    {
        return sprintf('%sK * %d月', $this->cur_salary_show, $this->cur_salary_count_show);
    }

    public function getAvatarUrlAttribute()
    {
        $url = 'images/resume_avatar_default_man.png';

        if (!empty($this->avatar)) {
            $url = Storage::disk('resume_avatar')->url($this->attributes['avatar']);
        } elseif ($this->sex === '女') {
            $url = 'images/resume_avatar_default_female.png';
        }

        return asset($url);
    }
}
