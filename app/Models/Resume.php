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
}
