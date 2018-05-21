<?php

namespace App\Http\Middleware;

use Closure;

class DebugMiddleware
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

        if( env('WECHAT_DEBUG') ) {
            $user = new \Overtrue\Socialite\User([
                'id' => 'oQCtm07gJkHD_VFyXwNsGon315qo',
                'nickname' => '觉觉',
                'avatar' => 'http://thirdwx.qlogo.cn/mmopen/Q3auHgzwzM7a7PP3S7lbbxYqIp1dev6SkibQlyDFB5WiaGwtdxzFuNoeonsxBZia1LATenGa7icEsIJIrImJlDR9GPgUFAELicSNsoXTEFOBeapM/132',
                'email' => '',
                'original' => [],
                'provider' => 'WeChat',
            ]);
            session(['wechat.oauth_user.default' => $user]);
        }

        return $next($request);
    }
}
