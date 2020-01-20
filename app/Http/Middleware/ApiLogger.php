<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiLogger
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
        return $next($request);
    }

    public function terminate(Request $request){

        if(env("API_LOGGER", true)){

            $startTime = LARAVEL_START;
            $endTime   = microtime(true);

            $log  = '[' . date('Y-m-d H:i:s') . ']';
            $log .= '[' . ($endTime-$startTime)*100 . 'ms]';
            $log .= '[' . $request->ip() . ']';
            $log .= '[' . $request->method() . ']';
            $log .= '[' . $request->fullUrl() . ']';

            //For Laravels default log system
            //Log::info($log);

            //For custom log files

            $fileName = "api_logger_" . date('Y-m-d H:i:s') . ".log";
            \File::append(storage_path('logs' . DIRECTORY_SEPARATOR . $fileName ), $log . "\n");

        }

    }
}
