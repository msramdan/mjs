<?php

namespace App\Http\Controllers\Legal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Legal\{StoreDokumenHrgaRequest, UpdateDokumenHrgaRequest};
use App\Models\Legal\DokumenHrga;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Jenssegers\Agent\Agent;

class DokumenHrgaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view dokumen hrga')->only('index', 'show');
        $this->middleware('permission:create dokumen hrga')->only('create');
        $this->middleware('permission:edit dokumen hrga')->only('edit', 'update');
        $this->middleware('permission:delete dokumen hrga')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = DokumenHrga::with('history_downloads')->withCount('history_downloads');

            return DataTables::of($query)
                ->addColumn('keterangan', function ($row) {
                    return Str::limit($row->keterangan, 200);
                })
                ->addColumn('action', 'legal.hrga._action')
                ->toJson();
        }

        return view('legal.hrga.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('legal.hrga.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDokumenHrgaRequest $request)
    {
        $attr = $request->validated();

        if ($request->file('file') && $request->file('file')->isValid()) {
            $filename = Str::slug($request->nama) . '-' . time() . '.' . $request->file->extension();

            $request->file->move(public_path('/dokumen-hrga'), $filename);

            $attr['file'] = $filename;
        }

        DokumenHrga::create($attr);

        Alert::toast('Tambah data berhasil', 'success');

        return redirect()->route('dokumen-hrga.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Legal\DokumenHrga  $dokumenHrga
     * @return \Illuminate\Http\Response
     */
    public function show(DokumenHrga $dokumenHrga)
    {
        $dokumenHrga->load('history_downloads', 'history_downloads.user:id,name')->loadCount('history_downloads');

        return view('legal.hrga.show', compact('dokumenHrga'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Legal\DokumenHrga  $dokumenHrga
     * @return \Illuminate\Http\Response
     */
    public function edit(DokumenHrga $dokumenHrga)
    {
        return view('legal.hrga.edit', compact('dokumenHrga'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Legal\DokumenHrga  $dokumenHrga
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDokumenHrgaRequest $request, DokumenHrga $dokumenHrga)
    {
        $attr = $request->validated();
        $attr['file'] = $dokumenHrga->file;

        if ($request->file('file') && $request->file('file')->isValid()) {
            // hapus file lama
            unlink(public_path("/dokumen-hrga/$dokumenHrga->file"));

            $filename = Str::slug($request->nama) . '-' . time() . '.' . $request->file->extension();

            $request->file->move(public_path('/dokumen-hrga'), $filename);

            $attr['file'] = $filename;
        }

        $dokumenHrga->update($attr);

        Alert::toast('Update data berhasil', 'success');

        return redirect()->route('dokumen-hrga.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Legal\DokumenHrga  $dokumenHrga
     * @return \Illuminate\Http\Response
     */
    public function destroy(DokumenHrga $dokumenHrga)
    {
        unlink(public_path("/dokumen-hrga/$dokumenHrga->file"));

        $dokumenHrga->delete();

        Alert::toast('Hapus data berhasil', 'success');

        return redirect()->route('dokumen-hrga.index');
    }

    public function download($filename)
    {
        $agent = new Agent();

        $dokumenHrga = DokumenHrga::select('id')->where('file', $filename)->firstOrFail();

        DB::table('history_download_hrga')->insert([
            'dokumen_hrga_id' => $dokumenHrga->id,
            'user_id' => auth()->id(),
            'language' => strtoupper($agent->languages()[0]),
            'device' => $agent->device(),
            'os' => $agent->platform() . ' ' . $agent->version($agent->platform()),
            'browser' => $agent->browser() . ' ' . $agent->version($agent->browser()),
            'robot' => $agent->robot(),
            'ip' => request()->ip(),
            'header' => request()->header('user-agent'),
            'created_at' => now()->toDateTimeString()
        ]);

        $path = public_path() . "/dokumen-hrga/$filename";

        $extension = \File::extension($filename);

        $headers = array(
            // type sesuai extension file
            'Content-Type: application/' . $extension,
        );

        /**
         * params
         * 1: lokasi file,
         * 2: nama file ketika didownload,
         * 3:header(optional)
         */
        return response()->download($path, $filename, $headers);
    }
}
