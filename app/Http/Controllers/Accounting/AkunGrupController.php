<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\AkunGrupRequest;
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
        return view('accounting.akun_grup.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AkunGrupRequest $request)
    {
        $data = $request->all();
        AkunGrup::create($data);
        Alert::toast('Tambah data berhasil', 'success');
        return redirect()->route('akun_grup.index');
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
    public function edit($id)
    {
        $data = AkunGrup::findOrFail($id);
        return view('accounting.akun_grup.edit')->with([
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Accounting\AkunGrup  $akunGrup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'account_group' => 'required|unique:account_group,account_group,'.$id,
            'report' => 'required',
        ]);
        $data = $request->all();
        $item = AkunGrup::findOrFail($id);
        $item->update($data);
        Alert::toast('Update data berhasil', 'success');
        return redirect()->route('akun_grup.index');
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
