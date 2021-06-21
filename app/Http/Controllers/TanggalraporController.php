<?php

namespace App\Http\Controllers;

use App\Models\TanggalRapor;
use Illuminate\Http\Request;

class TanggalraporController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if(isset($reques->mode)) {
                switch($request->mode) {
                    default:
                        $tanggals = [];
                        break;   
                }
            } else {
                $tanggals = TanggalRapor::all();
            }

            return response()->json(['success' => true, 'msg' => 'Data Tanggal Rapor', 'tanggals' => $tanggals], 200);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    /**

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            TanggalRapor::updateOrCreate(
                [
                    'periode_id' => $request->periode_id,
                    'jenis_rapor' => $request->jenis_rapor
                ],
                [
                    'tanggal' => $request->tanggal
                ]
            );
            return response()->json(['success' => true, 'msg' => 'Tanggal Rapor Disimpan.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TanggalRapor  $tanggalRapor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            TanggalRapor::find($id)->delete();
            return response()->json(['success' => true, 'msg' => 'Tanggal Rapor Dihapus.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()], 500);
        }
    }
}
