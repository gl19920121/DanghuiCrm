<?php

namespace App\Http\Services;

class FormateHelper
{
    private static $dateType = ['month', 'year'];

    public static function Date($data = null, $type = 'month')
    {
        $formate = 'Y-m';
        if ($type === 'year') {
            $formate = 'Y-m-d';
        }

        if (empty($data)) {
            return date($formate, time());
        }

        if (!in_array($type, self::$dateType)) {
            return false;
        }

        $data = str_replace('.', '-', $data);
        $data = str_replace('/', '-', $data);
        $dataArr = explode('-', $data);
        if (count($dataArr) < 3) {
            $data .= '-01';
        }

        $timestamp = strtotime($data);
        if ($timestamp === false) {
            return '';
        }
        return date($formate, $timestamp);
    }
}
