<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Storage;

class APIHelper
{
    private $url;

    public function __construct()
    {

    }

    // public function __construct($url)
    // {
    //     $this->url = $url;
    // }

    public function post($body, $apiStr)
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => $this->url
        ]);
        $res = $client->request('POST', $apiStr, [
            'form_params' => $body,
            'headers' => [
                'Content-type'=> 'application/json',
//                'Cookie'=> 'XDEBUG_SESSION=PHPSTORM',
                'Accept' => 'application/json',
                'Authorization' => 'APPCODE 4f30b199481849a5bcbc489bf2f6fede'
            ]
        ]);
        $data = $res->getBody()->getContents();

        return $data;
    }

    public function get($apiStr, $header)
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => $this->url
        ]);
        $res = $client->request('GET', $apiStr, ['headers' => $header]);
        $statusCode= $res->getStatusCode();

        $header= $res->getHeader('content-type');

        $data = $res->getBody();

        return $data;
    }

    public function resumesdkTest($filePath)
    {
        $url = "http://www.resumesdk.com/api/parse";          // 将127.0.0.1替换为部署服务的ip
        $uid = 2106160;
        $pwd = 'PeGc4y';

        $fname = storage_path('resume/append/'.$filePath);       // 替换为你的本地文件名
        // $fileData = file_get_contents($fname);
        $fileData = Storage::disk('resume_append')->get($filePath);
        // die(dd($fileData));
        $base_cont = base64_encode($fileData);

        $data = array(
            'file_cont' => $base_cont,      // 经base64编码过的文件内容
            'file_name' => $fname,          // 文件名
            'uid' => $uid,
            'pwd' => $pwd,
        );

        $data = json_encode($data, JSON_UNESCAPED_UNICODE);     // 需php5.4及以上才支持JSON_UNESCAPED_UNICODE
        $result = $this->http($url, $data);
        $res_js = json_decode($result, TRUE);
        return $res_js;
    }

    public function resumesdk($filePath)
    {
        $url = "http://resumesdk.market.alicloudapi.com/ResumeParser";          // 将127.0.0.1替换为部署服务的ip
        $appcode = "4f30b199481849a5bcbc489bf2f6fede";

        $fname = storage_path('resume/append/'.$filePath);       // 替换为你的本地文件名
        // $fileData = file_get_contents($fname);
        $fileData = Storage::disk('resume_append')->get($filePath);
        // die(dd($fileData));
        $base_cont = base64_encode($fileData);

        $data = array(
            'file_cont' => $base_cont,      // 经base64编码过的文件内容
            'file_name' => $fname,          // 文件名
            'need_avatar' => 0,         // 是否需要提取头像
            'ocr_type' => 1,                    // 1为高级ocr
        );

        $data = json_encode($data, JSON_UNESCAPED_UNICODE);     // 需php5.4及以上才支持JSON_UNESCAPED_UNICODE
        $result = $this->http($url, $data, $appcode);
        $res_js = json_decode($result, TRUE);
        return $res_js;
    }

    private function http($url, $data, $appcode = '')
    {
        $process = curl_init($url);

        $headers = array();

        if (!empty($appcode)) {
            array_push($headers, "Authorization:APPCODE " . $appcode);
        }

        array_push($headers, "Content-Type".":"."application/json; charset=UTF-8");
        curl_setopt($process, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($process, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($process, CURLOPT_HEADER, FALSE);
        curl_setopt($process, CURLOPT_TIMEOUT, 600);
        curl_setopt($process, CURLOPT_POST, TRUE);
        curl_setopt($process, CURLOPT_POSTFIELDS, $data);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
        $content = curl_exec($process);
        curl_close($process);

        return $content;
    }
}
