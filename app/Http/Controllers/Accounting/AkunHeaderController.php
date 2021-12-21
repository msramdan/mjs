<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Accounting\AkunHeader;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class AkunHeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $AkunHeader = AkunHeader::all();
        return view('accounting.akun_header.index')->with([
            'AkunHeader' => $AkunHeader
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
     * @param  \App\Models\Accounting\AkunHeader  $akunHeader
     * @return \Illuminate\Http\Response
     */
    public function show(AkunHeader $akunHeader)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Accounting\AkunHeader  $akunHeader
     * @return \Illuminate\Http\Response
     */
    public function edit(AkunHeader $akunHeader)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Accounting\AkunHeader  $akunHeader
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AkunHeader $akunHeader)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accounting\AkunHeader  $akunHeader
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $AkunHeader = AkunHeader::findOrFail($id);
        $AkunHeader->delete();
        Alert::success('Hapus Data', 'Berhasil');
        return redirect()->route('akun_grup.index');
    }
}
