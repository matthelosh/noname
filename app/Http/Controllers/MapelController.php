<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel;

class MapelController extends Controller
{
    public function index(Request $request)
    {
    	try {
            if ($request->tingkat) {
                $kelas = 'App\Models\Kelas'::where('kode_kelas', $request->tingkat)->with('mapels')->first();
                $mapels = $kelas->mapels;
            } else {
                $mapels = Mapel::all();
            }

    		return response()->json(['success' => true, 'msg' => 'Data Mapel', 'mapels' => $mapels], 200);
    	} catch (\Exception $e) {
			return response()->json(['success' => false, 'msg' =>  $e->getMessage()], 501);    		
    	}
    }

    public function store(Request $request)
    {
    	try {
    		Mapel::create($request->all());
    		return response()->json(['success' => true, 'msg' => 'Data Mapel Disimpan' ], 200);
    	} catch (\Exception $e) {
    		return response()->json(['success' => false, 'msg' =>  $e->getMessage()], 501);    
    	}
    }

    public function noGrade(Request $request)
    {
        $kelas_id = $request->kelas_id;

        try {
            $mapels = Mapel::whereDoesntHave('kelas', function($query) use ($kelas_id) {
                $query->where('kelas_mapel.kelas_id', $kelas_id);
            })->get();
            return response()->json(['success' => true, 'msg' => 'Data Mapel', 'mapels' => $mapels], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()], 501);
            
        }
    }
}
