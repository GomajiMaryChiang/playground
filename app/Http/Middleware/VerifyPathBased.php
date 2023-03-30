<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyPathBased
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
        /*
            防止 mews/captcha 套件定義的 route 造成 Path-Based Vulnerability
            只讓此專案有使用到的 uri 通過，未使用的導至 404 頁面
        */
        if ($request->is('captcha') || $request->is('captcha/*')) {
            if (!$request->is('captcha/src') && !$request->is('captcha/flat')) {
                return redirect('/404');
            }
        }

        return $next($request);
    }
}
