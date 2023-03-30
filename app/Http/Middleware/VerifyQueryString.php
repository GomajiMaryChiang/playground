<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyQueryString
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (empty($request->query())) {
            return $next($request);
        }

        $queryStringAry = $request->query();
        $keyPattern = '/^([\/\w\.\-+]*)?$/';
        $valuePattern = '/^([\/\w\.\-\{\}\?+=%&:,"]*)?$/';

        foreach ($queryStringAry as $key => $value) {
            // 檢查參數的 key
            if (isset($key) && !preg_match($keyPattern, $key)) {
                return redirect('/404');
            }

            // 檢查參數的 value
            if (isset($value)) {
                $value = is_array($value) ? json_encode($value) : ($key == 'keyword' ? urlencode($value) : $value);
                if (!preg_match($valuePattern, $value)) {
                    return redirect('/404');
                }
            }
        }
        return $next($request);
    }
}
