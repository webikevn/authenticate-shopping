<?php

namespace Webikevn\AuthenticateShopping\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Cookie;
use Webikevn\AuthenticateShopping\Models\TblMpSession;
use Webikevn\AuthenticateShopping\Services\Monoris;

class ShoppingAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $auth = \Auth::guard(config('shopping_authenticate.auth_driver'));
        $isSaveAuthenticateSession = config('shopping_authenticate.is_enable_store_session');
        $monoris = Monoris::getMonoris($request);
        if (!$monoris) {
            return $this->response($request);
        }
        $credentials = [
            'sess_key' => $monoris
        ];
        $isAttempt = $auth->attempt($credentials) ?: false;

        if (!$isAttempt && $request->wantsJson()) {
            return $this->response($request);
        }

        if ($isSaveAuthenticateSession) {
            $request->session()->setId(mb_substr($monoris, 0, 40));
            $sessionAuthenticate = $request->session()->get(TblMpSession::AUTHENTICATE);
            if (!$sessionAuthenticate) {
                $request->session()->put(TblMpSession::AUTHENTICATE, [
                    'last_login' => Carbon::now()->timestamp
                ]);
            } else {
                $sessionAuthenticate['last_login'] = Carbon::now()->timestamp;
                $request->session()->put(TblMpSession::AUTHENTICATE, $sessionAuthenticate);
            }
        }

        return $next($request);
    }


    /**
     * @param $request
     */
    private function response($request)
    {
        return response('Unauthorized.', 401);
    }
}
