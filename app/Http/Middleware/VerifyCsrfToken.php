<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //lt测试 验证接口 跳过csrf
        //'admin/user/*',
        //'admin/dictionaries/*',
        //'wechat*',
        'common*',
    ];

    public function handle($request, \Closure $next)
    {
        /*启用csrf*/
        return parent::handle($request, $next);

        /*禁用csrf*/
        //return $next($request);
    }
}
