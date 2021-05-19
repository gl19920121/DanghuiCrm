<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [];
    protected $guarded = [];

    public const natureArr = [
        'foreign' => ['text' => '外商独资/外企办事处', 'selected' => 'selected'],
        'joint_venture' => ['text' => '中外合营(合资/合作)'],
        'private' => ['text' => '私营/民营企业'],
        'state' => ['text' => '国有企业'],
        'listed' => ['text' => '国内上市公司'],
        'government' => ['text' => '政府机关／非盈利机构'],
        'institution' => ['text' => '事业单位'],
        'other' => ['text' => '其他']
    ];

    public const scaleArr = [
        ['text' => '1-49人'],
        ['text' => '50-99人'],
        ['text' => '100-499人'],
        ['text' => '500-999人'],
        ['text' => '1000-2000人'],
        ['text' => '2000-5000人'],
        ['text' => '5000-10000人'],
        ['text' => '10000人以上']
    ];

    public const investmentArr = [
        'angel' => ['text' => '天使轮', 'selected' => 'selected'],
        'round_a' => ['text' => 'A轮'],
        'round_b' => ['text' => 'B轮'],
        'round_c' => ['text' => 'C轮'],
        'round_d_and_above' => ['text' => 'D轮及以上'],
        'fuk' => ['text' => '已上市'],
        'strategic' => ['text' => '战略融资'],
        'undisclosed' => ['text' => '融资未公开'],
        'not_needed' => ['text' => '不需要融资'],
        'other' => ['text' => '其他']
    ];
}
