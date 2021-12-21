<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Accounting\AkunGrup;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class AkunGrupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $AkunGrup = AkunGrup::all();

        return view('accounting.akun_grup.index')->with([
            'AkunGrup' => $AkunGrup
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Accounting\AkunGrup  $akunGrup
     * @return \Illuminate\Http\Response
     */
    public function show(AkunGrup $akunGrup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Accounting\AkunGrup  $akunGrup
     * @return \Illuminate\Http\Response
     */
    public function edit(AkunGrup $akunGrup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Accounting\AkunGrup  $akunGrup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AkunGrup $akunGrup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accounting\AkunGrup  $akunGrup
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $AkunGrup = AkunGrup::findOrFail($id);

            $AkunGrup->delete();

            Alert::toast('Hapus data berhasil', 'success');
            return redirect()->route('akun_grup.index');
        } catch (\Throwable $th) {

            Alert::toast('Hapus data gagal', 'error');

            return redirect()->route('akun_grup.index');
        }
    }
}
