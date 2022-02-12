<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\StoreJurnalUmumRequest;
use App\Http\Requests\Accounting\UpdateJurnalUmumRequest;
use App\Models\Accounting\AkunCoa;
use App\Models\Accounting\JurnalUmum;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JurnalUmumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = JurnalUmum::with('akun_coa:id,kode,nama');

            return Datatables::of($query)
                ->addColumn('coa_kode', function ($row) {
                    return $row->akun_coa->kode;
                })
                ->addColumn('coa_nama', function ($row) {
                    return $row->akun_coa->nama;
                })
                ->addColumn('action', 'accounting.jurnal-umum._action')
                ->toJson();
        }

        return view('accounting.jurnal-umum.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounting.jurnal-umum.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJurnalUmumRequest $request)
    {
        DB::transaction(function () use ($request) {
            $jurnalUmum = [];

            foreach ($request->account_coa_id as $key => $req) {
                $jurnalUmum[] = [
                    'tanggal' => $request->tanggal,
                    'no_bukti' => $request->no_bukti,
                    'account_coa_id' => $request->account_coa_id[$key],
                    'deskripsi' => $request->deskripsi[$key],
                    'debit' => $request->debit[$key],
                    'kredit' => $request->kredit[$key],
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(),
                ];
            }

            JurnalUmum::insert($jurnalUmum);
        });

        return response()->json(['success'], 200);
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Accounting\JurnalUmum  $jurnalUmum
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(JurnalUmum $jurnalUmum)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Accounting\JurnalUmum  $jurnalUmum
     * @return \Illuminate\Http\Response
     */
    public function edit(JurnalUmum $jurnalUmum)
    {
        // jurnal yg no buktinya sama
        $relatedJurnals = JurnalUmum::where('no_bukti', $jurnalUmum->no_bukti)->get();

        return view('accounting.jurnal-umum.edit', compact('relatedJurnals', 'jurnalUmum'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Accounting\JurnalUmum  $jurnalUmum
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJurnalUmumRequest $request, JurnalUmum $jurnalUmum)
    {
        // hapus semua jurnal lama dengan berdasarkan no bukti
        JurnalUmum::where('no_bukti', $jurnalUmum->no_bukti)->delete();

        DB::transaction(function () use ($request) {
            $jurnalUmum = [];

            foreach ($request->account_coa_id as $key => $req) {
                $jurnalUmum[] = [
                    'tanggal' => $request->tanggal,
                    'no_bukti' => $request->no_bukti,
                    'account_coa_id' => $request->account_coa_id[$key],
                    'deskripsi' => $request->deskripsi[$key],
                    'debit' => $request->debit[$key],
                    'kredit' => $request->kredit[$key],
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(),
                ];
            }

            JurnalUmum::insert($jurnalUmum);
        });

        return response()->json(['success'], 200);
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\Accounting\JurnalUmum  $jurnalUmum
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(JurnalUmum $jurnalUmum)
    // {
    //     //
    // }
}