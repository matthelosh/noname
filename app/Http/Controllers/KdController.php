<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kd;

class KdController extends Controller
{
    public function index(Request $request)
    {
        $where = ($request->kelas) ? [['mapel_id','=', $request->mapel],['kelas_id','=',$request->kelas]] : ['mapel_id','=', $request->mapel];

        try {
            $kds = Kd::where($where)->get();
            return response()->json(['success' => true, 'msg' => 'Data KD', 'kds' => $kds], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()], 502);
        }
    }
}
