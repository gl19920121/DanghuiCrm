<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [];

    protected $guarded = [];

    public function resumes()
    {
        return $this->hasMany(Resume::class, 'job_id', 'id');
    }
}
