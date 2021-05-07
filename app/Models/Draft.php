<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    protected $fillable = [];

    protected $guarded = [];

    public function getDataAttribute()
    {
        return json_decode($this->attributes['data']);
    }

    public function getNameAttribute()
    {
        $data = json_decode($this->attributes['data']);
        return empty($data->name) ? '-' : $data->name;
    }

    public function getCompanyAttribute()
    {
        $data = json_decode($this->attributes['data']);
        return empty($data->company) ? '-' : $data->company;
    }

    public function getChannelAttribute()
    {
        $data = json_decode($this->attributes['data']);
        return json_decode($data->channel, true);
    }
}
