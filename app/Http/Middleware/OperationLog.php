<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class OperationLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        self::writeLog($request);

        return $response;
    }

    private function writeLog($request)
    {
        $uid = empty(Auth::user()) ? NULL : Auth::user()->id; //操作人
        $ip = $request->ip(); //操作的IP
        $path = $request->path(); //操作的路由
        $method = $request->method(); //操作的方法
        $input = $request->all(); //操作的内容

        $log = new \App\Models\OperationLog();
        $log->setAttribute('user_id', $uid);
        $log->setAttribute('ip', $ip);
        $log->setAttribute('path', $path);
        $log->setAttribute('method', $method);
        // $log->setAttribute('input', json_encode($input, JSON_UNESCAPED_UNICODE));
        $log->save();
    }
}
