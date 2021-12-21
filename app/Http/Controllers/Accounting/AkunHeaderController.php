<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\AkunHeaderRequest;
use App\Models\Accounting\AkunGrup;
use Illuminate\Support\Facades\DB;
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
        $AkunHeader = DB::table('account_header')
        ->join('account_group', 'account_group.id', '=', 'account_header.account_group_id')
        ->select('account_header.*', 'account_group.account_group')
        ->get();
        return view('accounting.akun_header.index')->with([
            'AkunHeader' => $AkunHeader
        ]);
    }

    public function create()
    {
        $AkunGrup = AkunGrup::all();
        return view('accounting.akun_header.create')->with([
            'AkunGrup' => $AkunGrup
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AkunHeaderRequest $request)
    {
        $data = $request->all();
        AkunHeader::create($data);
        Alert::toast('Tambah data berhasil', 'success');
        return redirect()->route('akun_header.index');
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
    public function edit($id)
    {
        $AkunGrup = AkunGrup::all();
        $data = AkunHeader::findOrFail($id);

        return view('accounting.akun_header.edit')->with([
            'data' => $data,
            'AkunGrup' => $AkunGrup
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Accounting\AkunHeader  $akunHeader
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'code_account_header' => 'required|unique:account_header,code_account_header,'.$id,
            'account_header' => 'required',
            'account_group_id' => 'required',
        ]);
        $data = $request->all();
        $item = AkunHeader::findOrFail($id);
        $item->update($data);
        Alert::toast('Update data berhasil', 'success');
        return redirect()->route('akun_header.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accounting\AkunHeader  $akunHeader
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $AkunHeader = AkunHeader::findOrFail($id);
            $AkunHeader->delete();
            Alert::toast('Hapus data berhasil', 'success');
            return redirect()->route('akun_header.index');
        } catch (\Throwable $th) {
            Alert::toast('Hapus data gagal', 'error');
            return redirect()->route('akun_header.index');
        }

    }
}
