<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Accounting\JurnalUmum;
use Illuminate\Http\Request;

class BukuBesarController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $generalLegders = JurnalUmum::select('id', 'tanggal', 'no_bukti', 'coa_id', 'deskripsi', 'debit', 'kredit')
            ->with('coa:id,kode,nama')
            ->whereBetween('tanggal', [$request->start_date, $request->end_date])
            ->where('coa_id', $request->coa)
            ->orderBy('tanggal')
            ->paginate();

        return view('accounting.buku-besar.index', compact('generalLegders'));
    }
}
