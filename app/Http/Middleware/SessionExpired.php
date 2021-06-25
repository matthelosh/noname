<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Session\Store;
use Auth;
use Session;
use Illuminate\Http\Request;

class SessionExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     protected $session;
     protected $timeout = 1200;

    public function __construct(Store $session) 
    {
        $this->session = $session;
    }
    

    
    public function handle(Request $request, Closure $next)
    {
        $isLoggedIn = $request->path() != '/logout';

        if ( ! session('lastActivityTime'))
            $this->session->put('lastActivityTime', time());
        elseif(time() - $this->session->get('lastActivityTime') > $this->timeout) {
            $this->session->forget('lastActivityTime');
            $cookie = cookie('intend', $isLoggedIn ? url()->current() : '/dashboard');
            auth()->logout();
            return redirect('/login')->withError('msg', 'Sesi Anda berakhir');
        }
        $isLoggedIn ? $this->session->put('lastActivityTime', time()) : $this->session->forget('lastActivityTime');
        return $next($request);
    }
}
