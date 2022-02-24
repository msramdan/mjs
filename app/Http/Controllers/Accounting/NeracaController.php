<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;
use App\Models\Accounting\Coa;
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
        $coas = Coa::all();

        $coaIds = [];
        foreach ($coas as $coa) {
            $coaIds[] = $coa->id;
        }

        $jurnalUmums = JurnalUmum::whereIn('coa_id', $coaIds)
            ->selectRaw("SUM(debit) as total_debit")
            ->selectRaw("SUM(kredit) as total_kredit")
            ->groupBy('coa_id')
            ->get();

        // dd($jurnalUmums);

        return $jurnalUmums;

        // $neracas = [];

        return view('accounting.neraca.index', compact('neracas'));
    }
}
