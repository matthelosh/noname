<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\Storage;
use Validator;


class SiswaController extends Controller
{
    public function index(Request $request)
    {
        switch($request->role){
            case 'admin':
                $siswas = Siswa::with('user', 'ortu')->with('rombel', function($q) use ($request) {
                    $q->where('periode_id', $request->session()->get('periode'));
                })->where('active', 1)->get();
                break;
            case 'wali':
                $rombel = 'App\Models\Rombel'::where([
                    ['guru_id', '=', $request->user()->userid],
                    ['periode_id', '=', $request->session()->get('periode')]
                ])->first();
                $siswas = Siswa::whereHas('rombel', function($q) use ($rombel){
                    $q->where('rombel_id', $rombel->id);
                })->with('ortu')->get();
                // $siswas = $rombel->siswas;
                break;
        }
        
        return response()->json(['success' => true, 'siswas' => $siswas,], 200);
    }

    public function nonmembers(Request $request)
    {
        try {
            
            // $rombel_id = $request->rombel;
            $periode = $request->periode;
            // dd($periode);
            // session(['periode' => $periode]);

            // $nonmembers = Siswa::whereDoesntHave('rombels', function($query) use ($rombel_id) {
            //     $query->where('rombel_id', $rombel_id);
            // })->get();
            $nonmembers = Siswa::whereDoesntHave('rombel', function($q) use($periode) {
                $q->where('periode_id', $periode);
            })->where('active', 1)->get();
            // dd($nonmembers); 
            return response()->json(['success' => true, 'nonmembers' => $nonmembers], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getCode().':'.$e->getMessage()], 502);
        }
        

    }

    public function inactivate(Request $request)
    {
        try {
            $siswas = $request->siswas;
            $namas = '';
            foreach($siswas as $siswa)
            {
                Siswa::where('id', $siswa['id'])->update(['active' => 0]);
                $namas .= $siswa['nama'].', ';
            }

            return response()->json(['success' => true, 'msg' => $namas . ' dinonaktifkan.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $siswa = json_decode($request->siswa);
        $foto = $request->foto;
        // dd($foto);
        // $request->foto->validate([
        //     'foto' => 'file|image'
        // ]);
        $rules = [
            // [
                'nik' => 'unique:siswas',
                'nisn' => 'required|unique:siswas',
                'nis' => 'required|unique:siswas',
                'nama' => 'required',
                'jk' => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'agama' => 'required',
                'alamat' => 'required',
                'desa' => 'required',
                'kec' => 'required',
                'kab' => 'required',
                'kode_pos' => 'required',
                'email' => 'email|unique:siswas',
                'sekolah_asal' => 'required',
                
            // ],

            // [
            //     'nik.unique' => 'NIK ini sudah dimiliki siswa lain',
            //     'nisn.required' => 'Data NISN harus diisi',
            //     'nisn.unique' => 'NISN ini sudah dimiliki siswa lain. Cek ulang',
            //     'nis.required' => 'Data NIS harus diisi',
            //     'nis.unique' => 'NIS ini sudah dimiliki siswa lain. Cek ulang',
            //     'nama.required' => 'Nama Siswa harus diisi',
            //     'jk.required' => 'Pilih Jenis Kelamin Siswa',
            //     'tempat_lahir.required' => 'Tempat Lahir Siswa harus diisi',
            //     'tanggal_lahir.required' => 'Tanggal Lahir Siswa harus diisi',
            //     'agama.required' => 'Pilih Agama Siswa',
            //     'alamat.required' => 'Isikan alamat dengan Jalan atau Dusun',
            //     'desa.required' => 'Isi Desa / Kelurahan tempat tinggal siswa',
            //     'kec.required' => 'Isi Kecamatan tempat tinggal siswa',
            //     'kab.required' => 'Isi Kabupaten / Kota tempat tinggal siswa',
            //     'kode_pos.required' => 'Isi Kabupaten / Kota tempat tinggal siswa',
            //     'email.email' => 'Format email salah. Cek lagi',
            //     'cek.unique' => 'Email ini sudah dimiliki siswa lain.',
            //     'sekolah_asal.required' => 'Isikan Sekolah asal (TK) siswa'
            // ]
        ];
            try {
                $create = Siswa::updateOrCreate(['nisn'=> $siswa->nisn,],[
                    'nik'           => $siswa->nik?? null,
                    
                    'nis'           => $siswa->nis,
                    'nama'          => $siswa->nama,
                    'jk'            => $siswa->jk,
                    'tempat_lahir'  => $siswa->tempat_lahir,
                    'tanggal_lahir' => $siswa->tanggal_lahir,
                    'agama'         => $siswa->agama,
                    'alamat'        => $siswa->alamat,
                    'rt'            => $siswa->rt?? null,
                    'rw'            => $siswa->rw?? null,
                    'desa'          => $siswa->desa,
                    'kec'           => $siswa->kec,
                    'kab'           => $siswa->kab,
                    'kode_pos'      => $siswa->kode_pos,
                    'hp'            => $siswa->hp?? null,
                    'email'         => $siswa->email?? null,
                    'sekolah_asal'  => $siswa->sekolah_asal,
                    'ortu_id'       => null
                ]);
                if ( $create ) {
                    $withFoto = '';
                    if ( $foto != 'undefined' ) {
                        Storage::putFileAs('public/img/siswas/', $foto, $siswa->nisn.'.jpg');
                        $withFoto = ' dengan foto.';
                    } else {
                        $withFoto = ' tanpa foto.';
                    }
                    return response()->json(['success' => true, 'msg' => 'Data Siswa baru disimpan' . $withFoto], 200);
                }
            } catch(\Exception $e) {
                return response()->json(['success' => false, 'msg' => $e->getCode().':'.$e->getMessage()], 500);
            }
    }
 
    public function import(Request $request)
    {
       try {
           $siswas = $request->siswas;
           foreach ( $siswas as $siswa ) 
           {
                Siswa::updateOrCreate(
                   [
                        'nisn' => $siswa['nisn'],
                   ],
                   [
                        'nik' => $siswa['nik'] ?? null,
                        'nis' => $siswa['nis'] ?? 'null',
                        'nama' => $siswa['nama'],
                        'jk' => strtolower($siswa['jk']),
                        'tempat_lahir' => $siswa['tempat_lahir'],
                        'tanggal_lahir' => $siswa['tanggal_lahir'],
                        'agama' => $siswa['agama'],
                        'alamat' => $siswa['alamat'],
                        'rt' => $siswa['rt'],
                        'rw' => $siswa['rw'],
                        'desa' => $siswa['desa'],
                        'kec' => $siswa['kec'],
                        'kab' => $siswa['kab'],
                        'kode_pos' => $siswa['kode_pos'],
                        'hp' => $siswa['hp'] ?? null,
                        'email' => $siswa['email'] ?? 'siswa@sdn1-bedalisodo.sch.id',
                        'sekolah_asal' => $siswa['sekolah_asal'] ?? null,
                        'ortu_id' => null
                   ]
                );
           }
           return response()->json(['success' => true, 'msg' => 'Data Siswa disimpan'], 200);
       } catch ( \Exception $e ) {
            return response()->json(['success' => false, 'msg' => $e->getCode().':' . $e->getMessage()], 501);
       }
    }

    public function destroy(Request $request, $id)
    {
        
        
        
        try {
            $siswa = Siswa::find($id)->with('rombel')->first();
            $siswa->rombel()->detach();
            Siswa::find($id)->delete();
            return response()->json(['success' => true, 'msg' => 'Data ' . $siswa->nama . ' dihapus.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getCode().':'.$e->getMessage()], 501);
        }
        
    }
}
