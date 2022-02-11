<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Accounting\AkunCoa;
use App\Models\Accounting\JurnalUmum;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;


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
            $query = JurnalUmum::query();
            return Datatables::of($query)
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
        $coa = AkunCoa::get()->all();
        return view('accounting.jurnal-umum.create', compact(['coa']));
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
     * @param  \App\Models\Accounting\JurnalUmum  $jurnalUmum
     * @return \Illuminate\Http\Response
     */
    public function show(JurnalUmum $jurnalUmum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Accounting\JurnalUmum  $jurnalUmum
     * @return \Illuminate\Http\Response
     */
    public function edit(JurnalUmum $jurnalUmum)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Accounting\JurnalUmum  $jurnalUmum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JurnalUmum $jurnalUmum)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accounting\JurnalUmum  $jurnalUmum
     * @return \Illuminate\Http\Response
     */
    public function destroy(JurnalUmum $jurnalUmum)
    {
        //
    }
}
