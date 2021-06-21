<?php

namespace App\Http\Controllers;

use App\Models\Ortu;
use App\Models\Siswa;
use Illuminate\Http\Request;

class OrtuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $nisn = $request->siswa;
            $or = (object)$request->ortu;
            $ortu = new Ortu();
            $ortu->nik_ayah = $or->nik_ayah;
            $ortu->nama_ayah = $or->nama_ayah;
            $ortu->job_ayah = $or->job_ayah;
            $ortu->nama_ibu = $or->nama_ibu;
            $ortu->job_ibu = $or->job_ibu;
            $ortu->nama_wali = $or->nama_wali;
            $ortu->job_wali = $or->job_wali;
            $ortu->alamat_wali = $or->alamat_wali;
            $ortu->save();

            Siswa::where('nisn', $nisn)->update(['ortu_id' => $ortu->id]);

            return response()->json(['success' => true, 'msg' => 'Data Prtu Disimpan', 'ortu_id' => $ortu->id], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ortu  $ortu
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        try {
            $ortu = Ortu::find($id);
            return response()->json(['success' => true, 'ortu' => $ortu], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ortu  $ortu
     * @return \Illuminate\Http\Response
     */
    public function edit(Ortu $ortu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ortu  $ortu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ortu $ortu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ortu  $ortu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ortu $ortu)
    {
        //
    }
}
