<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\AccessLog;
use App\Models\User;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Carbon;
class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $periode_aktif = 'App\Models\Periode'::where('active', true)->first();

        $login = Auth::attempt($credentials);
        if ($login) {
            $agent = new Agent();
            Session::put('periode', $periode_aktif->kode_periode);
            $usr = $this->user($request->username);
            $usr->last_seen_at = Carbon::now()->format('Y-m-d H:i:s');
            $usr->save();
            AccessLog::create(['user_id' => $usr->userid, 'os' => $agent->platform(), 'browser' => $agent->browser(), 'ip' => $request->ip()]);
            return response()->json(['success' => true], 200);
        } else {
            return response()->json(['success' => false, 'old' => $credentials, 'msg' => 'Username atau Sandi yang Anda Masukkan tidak sesuai.'], 403);
        }
    }

    public function logout(Request $request)
    {
       Auth::logout();
       $request->session()->invalidate();
       $request->session()->regenerateToken();
       return redirect('/');
    }

    public function user($username)
    {
      return User::where('username', $username)->first();
    }
}
