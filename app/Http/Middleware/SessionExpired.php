<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Session;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SessionExpired
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
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::guard()->user();
        $now = Carbon::now();
        $last_seen = carbon::parse($user->last_seen_at);
        $absence = $now->diffInMinutes($last_seen);

        if ($absence > config('session.lifetime')) {
            Auth::guard()->logout();
            $request->session()->invalidate();
            return $next($request);
        }

        $user->last_seen_at = $now->format('Y-m-d H:i:s');
        $user->save();

        return $next($request);
    }
}
