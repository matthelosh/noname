<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Role;
use App\Models\Menu;
use App\Models\User;
use App\Models\Guru;
use App\Models\Periode;
use Illuminate\Session\Store;
use Session;
class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        $user = $request->user() ? User::where('id', $request->user()->id)->with('userable.rombel')->first() : null;
        return array_merge(parent::share($request), [
            'appName' => config('app.name'),

            'user' => fn () => $user ? $user->userable : null,
            // 'user' => fn () => $request->user() ? $request->user()->with('userable')->only('id', 'nip', 'name', 'username', 'email', 'jk', 'hp', 'alamat', 'level', 'role') : null,

            'menus' => $this->menus($request->user()->role??null),

            'flash' => [
                'message' => fn () => $request->session()->get('message')
            ],
            'role' => $request->user() ? $request->user()->role : null,
            'periode' => $request->session()->get('periode'),
            'sekolah' => $this->sekolah(),
            'periode_aktif' => $this->periode_aktif($request->session()->get('periode')),
            'rombel' => $this->rombel($request->user()->userid??null, $request->user() ? $request->user()->role : null, $request->session()->get('periode')),
            'mapel' => ($request->user() && $request->user()->role != 'admin' && $request->user()->role != 'wali') ? $this->mapel($request->user()->role) : null,
            'session' => (time() - $request->session()->get('lastActivityTime')) .' - ' . config('session.lifetime')
        ]);
    }

    public function mapel($role) {
        $m = $role == 'gor' ? 'pjok' : ( // gpr | gkt | ghd | gbd | gkh
                $role == 'gben'  ? 'ben' : 'pabp'
            );

        $mapel = 'App\Models\Mapel'::where('kode_mapel', $m)->first();
        return $mapel;
    }

    public function menus($koderole)
    {
        if($koderole != null) {
            $role = Role::where('kode_role', $koderole)->first();
            $roles= Role::where('kode_role', $koderole)->with('menus', function($q) use ($role){
                $q->where('parent_id','=',0);
                $q->with('children', function($c) use ($role){
                    // $r = $role;
                    $c->whereHas('roles', function($r) use ($role){
                        $r->where('menu_role.role_id', '=', $role->id);
                    });
                    $c->orderBy('label');
                });

            })->first();
            // dd($roles->menus);
            return $roles ? $roles->menus : null;
        }
    }

    public function rombel($userid, $role, $periode)
    {
        $model = $role == 'siswa' ? 'App\Models\Siswa' : 'App\Models\Guru';
        if ( $role == 'siswa') {
            $user = $model::where('nisn', $userid)->with('rombel', function($q) use ($periode) {
                $q->where('periode_id', $periode);
            })->first();
            $rombel = $user->rombel[0] ?? null;
        } else {
            $user = $model::where('nip', $userid)->with('rombel', function($q) use ($periode) {
                $q->where('periode_id', $periode);
            })->first();
            $rombel = $user ? $user->rombel : null;
        }
        return $rombel??null;
    }

    public function periode_aktif($periode)
    {
        $periode = Periode::where('kode_periode', $periode)->first();
        return $periode;
    }

    public function sekolah()
    {
        $sekolah = 'App\Models\Sekolah'::with('ks')->first();
        // $sekolah = $sekolah ? $sekolah->with('ks') : null;
        // dd($sekolah);
        return $sekolah ?? null;

    }
}
