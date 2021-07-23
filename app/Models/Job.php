<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Auth;

class Job extends Model
{
    protected $fillable = [];

    protected $guarded = [];

    protected $casts = [
        'type' => 'array',
        'location' => 'array',
        'channel' => 'array'
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
                    $scope = $query->whereIn('status', [-1, 1]);
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
            $query->where('name', 'like', '%' . $name . '%');
            $id = str_replace('PN', '', $name);
            if (is_numeric($id)) {
                $query->orWhere('id', $id);
            }
            return $query;
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
                if (Gate::allows('job-not-need-check', Auth::user()->id)) {
                    $status = 1;
                } else {
                    $status = -1;
                }
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
        $location = json_decode($this->attributes['location']);
        if (!$location->city) {
            $location->city = $location->province;
        }
        return $location;
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
            $channel[$index] = trans('db.channel')[$value];
            if (in_array($value, trans('db.channel_remark')) && !empty($this->attributes['channel_remark'])) {
                $channelRemark = $this->attributes['channel_remark'];
                if ( isset( trans('db.source_remarks')[$channelRemark] )) {
                    $remarks = trans('db.source_remarks')[$channelRemark];
                } else {
                    $remarks = $channelRemark;
                }
                $channel[$index] .= sprintf('（%s）', $remarks);
            }
        }

        return implode('/', $channel);
    }

    public function getNatureShowAttribute()
    {
        return trans('db.job.nature')[$this->attributes['nature']];
    }

    public function getWelfareShowAttribute()
    {
        return trans('db.welfare')[$this->attributes['welfare']];
    }

    public function getEducationShowAttribute()
    {
        return trans('db.education')[$this->attributes['education']];
    }

    public function getExperienceShowAttribute()
    {
        return trans('db.experience')[$this->attributes['experience']];
    }

    public function getUrgencyLevelShowAttribute()
    {
        return trans('db.job.urgency_level')[$this->attributes['urgency_level']];
    }
}
