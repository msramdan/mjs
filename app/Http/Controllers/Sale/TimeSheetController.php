<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Models\Sale\TimeSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimeSheetController extends Controller
{

    public function index()
    {
        $data = TimeSheet::join('spal', 'spal.id', '=', 'time_sheets.spal_id')
            ->get(['time_sheets.*', 'spal.kode']);
        return view('sale.time_sheet.index')->with([
            'data' => $data
        ]);
    }

    public function create()
    {
        $data = DB::table('spal')
        ->select('kode','id')
        ->get();
        return view('sale.time_sheet.create')->with([
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        echo "ramdan";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
