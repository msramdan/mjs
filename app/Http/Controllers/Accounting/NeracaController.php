<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;
use App\Models\Accounting\Coa;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Accounting\JurnalUmum;

class NeracaController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // config()->set('database.connections.mysql.strict', false);

        $parents = Coa::select('id')->where('parent', null)->get();

        $headerIds = [];
        foreach ($parents as $parent) {
            $headerIds[] = $parent->id;
        }

        $coaIds = [];
        $headers = Coa::select('id')->whereIn('parent', $headerIds)->get();
        foreach ($headers as $header) {
            $coaIds[] = $header->id;
        }

        $coas = Coa::select('id')->whereIn('parent', $coaIds)->get();

        $mergeCoas = array_merge($coas->toArray(), $parents->toArray());
        // return $mergeCoas;

        $neracas = [];
        $detailCoas = [];
        foreach ($mergeCoas as $key => $coa) {
            // $neracas[] = $coa['id'];


            // $detailCoas[] = Coa::where('parent', $coa->id)->get();

            // // $neracas[] = Coa::with('jurnals')->where('parent', $coa->id)->get();

            // ->whereHas('coa', function ($row) use ($coa) {
            // $row->where('co', $coa->id);
            // })

            $neracas[] = JurnalUmum::with('coa:id,kode,nama')
                ->select(
                    'id',
                    'coa_id',
                    'debit',
                    'kredit',
                    DB::raw('sum(debit) as sum_debit'),
                    DB::raw('sum(kredit) as sum_kredit'),
                )
                ->where('coa_id', $coa['id'])
                ->groupBy('coa_id')
                ->get();
        }

        // asort($neracas);
        return $neracas;


        // JurnalUmum::with('coa:id,kode,nama')
        //         ->select(
        //             'id',
        //             'coa_id',
        //             'tanggal',
        //             'no_bukti',
        //             'debit',
        //             'kredit',
        //             DB::raw('sum(debit) as sum_debit'),
        //             DB::raw('sum(kredit) as sum_kredit'),
        //         )
        //         ->groupBy('coa_id')
        //         ->get();

        // $coaIds = [];
        // foreach ($coas as $coa) {
        //     ;

        //     dump($jurnalUmums);
        // }
        // dd('end');

        // $jurnalUmums = JurnalUmum::whereIn('coa_id', $coaIds)
        //     ->selectRaw("SUM(debit) as total_debit")
        //     ->selectRaw("SUM(kredit) as total_kredit")
        //     ->groupBy('coa_id')
        //     ->get();

        // dd($jurnalUmums);

        // return $jurnalUmums;

        // $neracas = [];

        return view('accounting.neraca.index', compact('neracas'));
    }
}
