<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sale\StoreTimeSheetRequest;
use App\Http\Requests\Sale\UpdateTimeSheetRequest;
use App\Models\Sale\DetailTimeSheet;
use App\Models\Sale\TimeSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

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
        $spal = DB::table('spal')
            ->select('kode', 'id')
            ->get();

        return view('sale.time_sheet.create')->with([
            'spal' => $spal
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTimeSheetRequest $request)
    {
        $lamaWaktu = $this->calculateDay(explode(' ', $request->lama_waktu));

        // return 48 % 24;
        // return explode(' ', $request->lama_waktu)[0];

        // return $lamaWaktu;

        DB::transaction(function () use ($request, $lamaWaktu) {
            $timeSheet = TimeSheet::create([
                'spal_id' => $request->spal,
                'kode_time_sheet' => $this->generateCode(),
                'qty' => isset($lamaWaktu['hari']) ? floatval($lamaWaktu['hari'] . '.' . $lamaWaktu['jam']) : 1,
                'hari' => isset($lamaWaktu['hari']) ? $lamaWaktu['hari'] : 0,
                'jam' => $lamaWaktu['jam'],
                'menit' => $lamaWaktu['menit'],
            ]);

            $detail = [];
            foreach ($request->date as $i => $d) {
                $detail[] = new DetailTimeSheet([
                    'date' => $d,
                    'remark' => $request->remark[$i],
                    'from' => $request->from[$i],
                    'to' => $request->to[$i],
                    'keterangan' => $request->keterangan[$i],
                ]);
            }

            $timeSheet->detail_time_sheets()->saveMany($detail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $spal = DB::table('spal')->select('kode', 'id')->get();

        $timeSheet = TimeSheet::with('detail_time_sheets')->findOrFail($id);

        return view('sale.time_sheet.edit', compact('timeSheet', 'spal'));
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
        $timeSheet = TimeSheet::with('detail_time_sheets')->findOrFail($id);

        $lamaWaktu = $this->calculateDay(explode(' ', $request->lama_waktu));

        DB::transaction(function () use ($request, $lamaWaktu, $timeSheet) {
            $timeSheet->update([
                'spal_id' => $request->spal,
                'qty' => isset($lamaWaktu['hari']) ? floatval($lamaWaktu['hari'] . '.' . $lamaWaktu['jam']) : 1,
                'hari' => isset($lamaWaktu['hari']) ? $lamaWaktu['hari'] : 0,
                'jam' => $lamaWaktu['jam'],
                'menit' => $lamaWaktu['menit'],
            ]);

            // hapus data detail lama
            $timeSheet->detail_time_sheets()->delete();

            $detail = [];
            foreach ($request->date as $i => $d) {
                $detail[] = new DetailTimeSheet([
                    'date' => $d,
                    'remark' => $request->remark[$i],
                    'from' => $request->from[$i],
                    'to' => $request->to[$i],
                    'keterangan' => $request->keterangan[$i],
                ]);
            }

            $timeSheet->detail_time_sheets()->saveMany($detail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TimeSheet::findOrFail($id)->delete();

        Alert::toast('Hapus data berhasil', 'success');

        return redirect()->route('time_sheet.index');
    }

    /**
     * Generate unique & auto increment code by date.
     *
     * @return \Illuminate\Http\Response
     */
    public function generateCode()
    {
        // kalo diakses lewat browser/url/bukan ajax
        abort_if(!request()->ajax(), 403);

        $kode = 'TS';
        $count = TimeSheet::count();
        $count = $count + 1;

        if ($count < 100) {
            $kode = $kode . '000' . $count;
        } elseif ($count >= 100 && $count < 1000) {
            $kode =  $kode . '0' . $count;
        } else {
            $kode = $kode . $count;
        }

        return $kode;
    }

    public function calculateDay(array $lamaWaktu)
    {
        // loop $lamaWaktu['jam]
        $hari = 0;
        $jam = intval($lamaWaktu[0]);
        $menit = intval($lamaWaktu[2]);

        for ($i = 0; $i < $lamaWaktu[0]; $i++) {
            if ($i >= 24) {
                if ($i % 24 === 0) {
                    // $jam += $i % 24;
                    $hari++;
                } elseif ($i % 24 != 0) {
                    $jam += $i % 24;
                }
            }

            // if ($lamaWaktu[0] >= 24) {
            //     $lamaWaktu[0] = $lamaWaktu[0] - 24;
            //     // hari
            //     $lamaWaktu[4] = 1;
            // } elseif ($lamaWaktu[0] >= 48) {
            //     $lamaWaktu[0] = $lamaWaktu[0] - 48;
            //     $lamaWaktu[4] = 2;
            // } elseif ($lamaWaktu[0] >= 72) {
            //     $lamaWaktu[0] = $lamaWaktu[0] - 72;
            //     $lamaWaktu[4] = 3;
            // } elseif ($lamaWaktu[0] >= 96) {
            //     $lamaWaktu[0] = $lamaWaktu[0] - 96;
            //     $lamaWaktu[4] = 4;
            // } elseif ($lamaWaktu[0] >= 120) {
            //     $lamaWaktu[0] = $lamaWaktu[0] - 120;
            //     $lamaWaktu[4] = 5;
            // } elseif ($lamaWaktu[0] >= 144) {
            //     $lamaWaktu[0] = $lamaWaktu[0] - 144;
            //     $lamaWaktu[4] = 6;
            // } elseif ($lamaWaktu[0] >= 168) {
            //     $lamaWaktu[0] = $lamaWaktu[0] - 168;
            //     $lamaWaktu[4] = 7;
            // } elseif ($lamaWaktu[0] >= 192) {
            //     $lamaWaktu[0] = $lamaWaktu[0] - 192;
            //     $lamaWaktu[4] = 8;
            // } elseif ($lamaWaktu[0] >= 216) {
            //     $lamaWaktu[0] = $lamaWaktu[0] - 216;
            //     $lamaWaktu[4] = 9;
            // } elseif ($lamaWaktu[0] >= 240) {
            //     $lamaWaktu[0] = $lamaWaktu[0] - 240;
            //     $lamaWaktu[4] = 10;
            // }
        }

        return ['hari' => $hari, 'jam' => $jam, 'menit' => $menit];
    }
}
