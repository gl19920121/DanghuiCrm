<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    protected $fillable = [];

    protected $guarded = [];

    protected $casts = [
        'data' => 'array'
    ];

    public function getNameAttribute()
    {
        return !empty($this->data['name']) ? $this->data['name'] : '-';
    }

    public function getCompanyNameAttribute()
    {
        return isset($this->data['company']['name']) ? $this->data['company']['name'] : '-';
    }

    public function getChannelAttribute()
    {
        $channel = $this->data['channel'];

        foreach ($channel as $index => $value) {
            $channel[$index] = trans('db.channel')[$value];
            if (in_array($value, trans('db.channel_remark')) && !empty($this->data['channel_remark'])) {
                $channel[$index] .= sprintf('（%s）', $this->data['channel_remark']);
            }
        }

        return implode('/', $channel);
    }
}
