<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Job;

class Resume extends Model
{
    protected $fillable = [];
    protected $guarded = [];

    public const workYearsArr = [
        '-1' => ['text' => '学生在读'],
        '-2' => ['text' => '应届毕业生']
    ];

    public const educationArr = [
        'high_schoo' => ['text' => '高中'],
        'junior' => ['text' => '专科'],
        'undergraduate' => ['text' => '本科'],
        'master' => ['text' => '硕士'],
        'doctor' => ['text' => '博士']
    ];

    public const jobhunterStatusArr = [
        '0' => ['text' => '在职-暂不考虑'],
        '1' => ['text' => '在职-考虑机会'],
        '2' => ['text' => '在职-月内到岗'],
        '3' => ['text' => '离职-随时到岗']
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
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

    public function getWorkYearsAttribute()
    {
        $workYears = $this->attributes['work_years'];
        $workYearsFlag = $this->attributes['work_years_flag'];

        switch ($workYearsFlag) {
            case 1:
                $workYears = '学生在读';
                break;
            case 2:
                $workYears = '应届毕业生';
                break;

            default:
                $workYears = sprintf('%s年', $workYears);
                break;
        }

        return $workYears;
    }
}
