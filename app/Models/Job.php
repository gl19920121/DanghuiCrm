<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [];
    protected $guarded = [];
    protected $casts = [
        'type' => 'array',
        'location' => 'array',
        'channel' => 'array'
    ];

    public const natureArr = [
        'full' => ['text' => '全职', 'selected' => 'selected'],
        'part' => ['text' => '兼职'],
        'all' => ['text' => '全职/兼职']
    ];
    public const welfareArr = [
        'social_insurance' => ['text' => '社会保险', 'selected' => 'selected'],
        'five_social_insurance_and_one_housing_fund' => ['text' => '五险一金'],
        'four_social_insurance_and_one_housing_fund' => ['text' => '四险一金']
    ];
    public const educationArr = [
        'unlimited' => ['text' => '不限', 'selected' => 'selected'],
        'high_schoo' => ['text' => '高中'],
        'junior' => ['text' => '专科'],
        'undergraduate' => ['text' => '本科'],
        'master' => ['text' => '硕士'],
        'doctor' => ['text' => '博士']
    ];
    public const experienceArr = [
        'unlimited' => ['text' => '经验不限'],
        'school' => ['text' => '学生在读'],
        'fresh_graduates' => ['text' => '应届毕业生'],
        'primary' => ['text' => '1-3'],
        'middle' => ['text' => '3-5'],
        'high' => ['text' => '5-10'],
        'expert' => ['text' => '10年以上']
    ];
    public const urgencyLevelArr = [
        '0' => ['text' => '标准', 'checked' => 'checked'],
        '1' => ['text' => '急聘']
    ];
    public const channelArr = [
        'applets' => ['text' => '小程序'],
        'website' => ['text' => '官网'],
        'other_platform' => ['text' => '其他', 'has_remark' => true]
    ];



    public function releaseUser()
    {
        return $this->belongsTo(User::class, 'release_uid');
    }

    public function executeUser()
    {
        return $this->belongsTo(User::class, 'execute_uid');
    }

    public function resumes()
    {
        return $this->hasMany(Resume::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }



    public function scopeActive($query)
    {
        return $query->whereIn('status', [1, 2]);
    }
    public function scopeDoing($query)
    {
        return $query->where('status', 1);
    }

    public function scopePause($query)
    {
        return $query->where('status', 2);
    }

    public function scopeEnd($query)
    {
        return $query->where('status', 0);
    }

    public function scopeExecuteUser($query, $uid)
    {
        return $query->where('execute_uid', $uid);
    }

    public function scopeStatus($query, $status)
    {
        $scope;

        if (is_numeric($status)) {
            $scope = $query->where('status', $status);
        } else {
            $tab = str_replace('job_', '', $status);
            switch ($tab) {
                case 'doing':
                    $scope = $query->where('status', 1);
                    break;
                case 'pause':
                    $scope = $query->where('status', 2);
                    break;
                case 'end':
                    $scope = $query->where('status', 0);
                    break;
                case 'need_check':
                    $scope = $query->where('status', -1);
                    break;

                default:
                    $scope = $query->where('status', 1);
                    break;
            }
        }

        return $scope;
    }

    public function scopeBranch($query, $uids)
    {
        return $query->whereIn('execute_uid', $uids);
    }

    public function scopeSearchByName($query, $name)
    {
        if (!empty($name)) {
            return $query->where('name', 'like', '%' . $name . '%');
        }
    }

    public function scopeSearchByUrgencyLevel($query, $level)
    {
        if (is_numeric($level)) {
            return $query->where('urgency_level', $level);
        }
    }

    public function scopeSearchByChannel($query, $channel)
    {
        if (!empty($channel)) {
            return $query->whereJsonContains('channel', $channel);
        }
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
                $status = 0;
                break;
            default:
                $status = 1;
                break;
        }
        $this->attributes['status'] = $status;
    }

    public function getStatusShowAttribute()
    {
        $status = $this->status;

        switch ($status) {
            case -1:
                $status = '审核中';
                break;
            case 1:
                $status = '已发布';
                break;
            case 2:
                $status = '已暂停';
                break;
            case 0:
                $status = '已结束';
                break;

            default:
                break;
        }

        return $status;
    }

    public function getNoAttribute()
    {
        return sprintf('PN%s', str_pad($this->attributes['id'], 8, "0", STR_PAD_LEFT));
    }

    public function getTypeAttribute()
    {
        return json_decode($this->attributes['type']);
    }

    public function getTypeShowAttribute()
    {
        return $this->getTypeAttribute()->rd;
    }

    public function getLocationAttribute()
    {
        return json_decode($this->attributes['location']);
    }

    public function getLocationShowAttribute()
    {
        $location = json_decode($this->attributes['location'], true);
        return sprintf('%s-%s-%s', $location['province'], $location['city'], $location['district']);
    }

    public function getSalaryShowAttribute()
    {
        return sprintf('%dK-%dK', $this->attributes['salary_min'], $this->attributes['salary_max']);
    }

    public function getAgeShowAttribute()
    {
        return sprintf('%d岁-%d岁', $this->attributes['age_min'], $this->attributes['age_max']);
    }

    public function getChannelAttribute()
    {
        return json_decode($this->attributes['channel'], true);
    }

    public function getChannelShowAttribute()
    {
        $channel = $this->channel;

        foreach ($channel as $index => $value) {
            $channel[$index] = $this->channelArr[$value]['text'];
            if (isset($this->channelArr[$value]['has_remark']) && $this->channelArr[$value]['has_remark']) {
                $channel[$index] .= sprintf('（%s）', $this->attributes['channel_remark']);
            }
        }

        return implode('/', $channel);
    }

    public function getChannelArrAttribute()
    {
        $channelArr = self::channelArr;

        foreach ($channelArr as $key => $value) {
            if (in_array($key, $this->channel)) {
                $channelArr[$key]['checked'] = 'checked';
            } else {
                $channelArr[$key]['checked'] = '';
            }
        }

        return $channelArr;
    }

    public function getNatureShowAttribute()
    {
        $nature = self::natureArr[$this->attributes['nature']]['text'];
        return $nature;
    }

    public function getNatureArrAttribute()
    {
        $natureArr = self::natureArr;

        foreach ($natureArr as $key => $value) {
            if ($key === $this->attributes['nature']) {
                $natureArr[$key]['selected'] = 'selected';
            } else {
                $natureArr[$key]['selected'] = '';
            }
        }

        return $natureArr;
    }

    public function getWelfareShowAttribute()
    {
        $welfare = self::welfareArr[$this->attributes['welfare']]['text'];
        return $welfare;
    }

    public function getWelfareArrAttribute()
    {
        $welfareArr = self::welfareArr;

        foreach ($welfareArr as $key => $value) {
            if ($key === $this->attributes['welfare']) {
                $welfareArr[$key]['selected'] = 'selected';
            } else {
                $welfareArr[$key]['selected'] = '';
            }
        }

        return $welfareArr;
    }

    public function getEducationShowAttribute()
    {
        $education = self::educationArr[$this->attributes['education']]['text'];
        return $education;
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

    public function getExperienceShowAttribute()
    {
        $experience = self::experienceArr[$this->attributes['experience']]['text'];
        return $experience;
    }

    public function getExperienceArrAttribute()
    {
        $experienceArr = self::experienceArr;

        foreach ($experienceArr as $key => $value) {
            if ($key === $this->attributes['experience']) {
                $experienceArr[$key]['selected'] = 'selected';
            } else {
                $experienceArr[$key]['selected'] = '';
            }
        }

        return $experienceArr;
    }

    public function getUrgencyLevelShowAttribute()
    {
        $urgencyLevel = self::urgencyLevelArr[$this->attributes['urgency_level']]['text'];
        return $urgencyLevel;
    }

    public function getUrgencyLevelArrAttribute()
    {
        $urgencyLevelArr = self::urgencyLevelArr;

        foreach ($urgencyLevelArr as $key => $value) {
            if ($key === $this->attributes['urgency_level']) {
                $urgencyLevelArr[$key]['checked'] = 'checked';
            } else {
                $urgencyLevelArr[$key]['checked'] = '';
            }
        }

        return $urgencyLevelArr;
    }
}
