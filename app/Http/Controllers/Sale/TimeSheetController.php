<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sale\{StoreTimeSheetRequest, UpdateTimeSheetRequest};
use App\Models\Sale\{TimeSheet, DetailTimeSheet};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class TimeSheetController extends Controller
{

    public function index()
    {
        $time_sheets = TimeSheet::join('spal', 'spal.id', '=', 'time_sheets.spal_id')->get(['time_sheets.*', 'spal.kode']);

        return view('sale.time_sheet.index', compact('time_sheets'));
    }

    public function create()
    {
        $spal = DB::table('spal')->select('kode', 'id')->orderByDesc('updated_at')->get();

        return view('sale.time_sheet.create', compact('spal'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \IlluminateHttp\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * will generate array like:
         * ['1', 'hari', '8', 'jam', '3', 'menit']
         */
        $lamaWaktu = explode(' ', $request->lama_waktu);

        DB::transaction(function () use ($request, $lamaWaktu) {
            $timeSheet = TimeSheet::create([
                'spal_id' => $request->spal,
                'kode_time_sheet' => $this->generateCode(),
                'qty' => floatval($lamaWaktu[0] . '.' . $lamaWaktu[2]),
                'hari' => $lamaWaktu[0],
                'jam' => $lamaWaktu[2],
                'menit' => $lamaWaktu[4],
            ]);

            $detail = [];
            foreach ($request->date as $i => $d) {
                $detail[] = new DetailTimeSheet([
                    'date' => $d,
                    'remark' => $request->remark[$i],
                    'from' => $request->from[$i],
                    'to' => $request->to[$i],
                    'keterangan' => $request->keterangan[$i],
                    'is_count' => $request->is_count[$i] == 'true' ? 1 : 0,
                ]);
            }

            $timeSheet->detail_time_sheets()->saveMany($detail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $spal = DB::table('spal')->select('kode', 'id')->orderByDesc('updated_at')->get();

        $timeSheet = TimeSheet::with('detail_time_sheets')->findOrFail($id);

        return view('sale.time_sheet.edit', compact('timeSheet', 'spal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \IlluminateHttp\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $timeSheet = TimeSheet::with('detail_time_sheets')->findOrFail($id);

        $lamaWaktu = explode(' ', $request->lama_waktu);

        DB::transaction(function () use ($request, $lamaWaktu, $timeSheet) {
            $timeSheet->update([
                'spal_id' => $request->spal,
                'kode_time_sheet' => $this->generateCode(),
                'qty' => floatval($lamaWaktu[0] . '.' . $lamaWaktu[2]),
                'hari' => $lamaWaktu[0],
                'jam' => $lamaWaktu[2],
                'menit' => $lamaWaktu[4],
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
                    'is_count' => $request->is_count[$i] == 'true' ? 1 : 0,
                ]);
            }

            $timeSheet->detail_time_sheets()->saveMany($detail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
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
}
