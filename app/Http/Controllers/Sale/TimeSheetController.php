<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sale\StoreTimeSheetRequest;
use App\Http\Requests\Sale\UpdateTimeSheetRequest;
use App\Models\Sale\DetailTimeSheet;
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
            ->select('kode', 'id')
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
        return $request;

        // DB::transaction(function () use ($request) {
        //     $timeSheet = TimeSheet::create([
        //         'spal_id' => $request->spal,
        //         'kode_time_sheet' => 'TS001',
        //         'qty' => 6,
        //         'hari' => 4,
        //         'jam' => 8,
        //         'menit' => 10,
        //     ]);

        //     $detail = [];
        //     foreach ($request->date as $i => $d) {
        //         $detail[] = new DetailTimeSheet([
        //             'date' => $d,
        //             'remark' => $request->remark[$i],
        //             'from' => $request->from[$i],
        //             'to' => $request->to[$i],
        //             'keterangan' => $request->keterangan[$i],
        //         ]);
        //     }

        //     $timeSheet->detail_time_sheet($detail);
        // });

        // return response()->json(['success'], 200);
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
    public function update(UpdateTimeSheetRequest $request, $id)
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
