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
        $channel = json_decode($data->channel);

        foreach ($channel as $index => $value) {
            $channel[$index] = Job::channelArr[$value]['text'];
            if (isset(Job::channelArr[$value]['has_remark']) && Job::channelArr[$value]['has_remark']) {
                $channel[$index] .= sprintf('（%s）', $data->channel_remark);
            }
        }

        return implode('/', $channel);
    }
}
