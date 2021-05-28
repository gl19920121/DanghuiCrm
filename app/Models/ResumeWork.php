<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResumeWork extends Model
{
    public function getCompanyIndustryAttribute()
    {
        return json_decode($this->attributes['company_industry']);
    }

    public function getCompanyIndustryShowAttribute()
    {
        return $this->company_industry->th;
    }

    public function getJobTypeAttribute()
    {
        return json_decode($this->attributes['job_type']);
    }

    public function getJobTypeShowAttribute()
    {
        return $this->job_type->rd;
    }
}
