<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Job;

class Resume extends Model
{
    protected $fillable = [];

    protected $guarded = [];

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
