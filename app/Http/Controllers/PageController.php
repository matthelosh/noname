<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Pemetaan;

class PageController extends Controller
{
    public function dashboard() {
        return Inertia::render('Home', ['page' => 'dashboard', 'page_title' => 'Dashboard']);
    }

    public function about() {
        $datas = Pemetaan::where([
            ['semester','=','1'],
            ['pemetaans.mapel_id','=','ppkn'],
            ['pemetaans.kelas_id','=','1'],
            ['pemetaans.subtema_id','=','111'],
            ['kds.mapel_id','=','ppkn']
        ])->select('pemetaans.kd_id', 'kds.teks')->join('kds', function($join){
            $join->on('kds.kode_kd','=','pemetaans.kd_id');
        })->groupBy('pemetaans.kd_id', 'kds.teks')->get();
        // dd($datas);
        return Inertia::render('About', ['page' => 'about', 'page_title' => 'About', 'datas'=>$datas]);
    }

    public function profile(Request $request)
    {
        return Inertia::render('Profile', ['page' => 'profile', 'page_title' => 'Profile']);
    }

    public function user() {
        return Inertia::render('User', ['page' => 'user', 'page_title' => 'Pengguna']);
    }

    public function siswa(Request $request)
    {
        return Inertia::render('Siswa', ['page' => 'siswa', 'page_title' => 'Siswa']);
    }

    public function rombel(Request $request)
    {
        return Inertia::render('Rombel', ['page' => 'rombel', 'page_title' => 'Rombel']);
    }
    public function kelas(Request $request)
    {
        return Inertia::render('Kelas', ['page' => 'kelas', 'page_title' => 'Kelas']);
    }

    public function prosem(Request $request)
    {
        return Inertia::render('Prosem', ['page' => 'prosem', 'page_titl' => 'Program Semester']);
    }
    public function mapel(Request $request)
    {
        return Inertia::render('Mapel', ['page' => 'mapel', 'page_title' => 'Mapel']);
    }

    public function periode(Request $request)
    {
        return Inertia::render('Periode', ['page'=>'periode', 'page_title' => 'Periode']);
    }

    public function sekolah(Request $request)
    {
        return Inertia::render('Sekolah', ['page' => 'sekolah', 'page_title' => 'Sekolah']);
    }

    public function pembelajaran(Request $request)
    {
        return Inertia::render('Pembelajaran', ['page' => 'pembelajaran', 'page_title' => 'Pembelajaran']);
    }
    public function penilaian(Request $request)
    {
        return Inertia::render('Penilaian', ['page' => 'penilaian', 'page_title' => 'Penilaian']);
    }

    public function rapor(Request $request)
    {
        return Inertia::render('Rapor', ['page' => 'rapor', 'page_title' => 'Rapor']);
    }

    public function pengaturanRapor(Request $request)
    {
        return inertia::render('Setting/Rapor', ['page' => 'setting-rapor', 'page_title' => 'Pengaturan Rapor']);
    }
}
