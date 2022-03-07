<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Accounting\Coa;

class LabarugiController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $coaHeaders = Coa::select('id', 'kode', 'nama')
        ->where('parent', null)
        ->where('type_report', 'laba_rugi')
        ->orderBy('kode','asc')
        ->get();
        // return $coaHeaders;

        return view('accounting.labarugi.index',compact('coaHeaders'));
    }
}
