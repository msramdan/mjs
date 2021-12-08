<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sale\{StoreSpalRequest, UpdateSpalRequest};
use App\Models\Sale\Spal;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class SpalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Spal::with('customer:id,nama')->latest('updated_at');

            return DataTables::of($query)
                ->addColumn('customer', function ($row) {
                    return $row->customer->nama;
                })
                ->addColumn('action', 'sale.spal._action')
                ->toJson();
        }

        return view('sale.spal.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sale.spal.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSpalRequest $request)
    {
        $attr = $request->validated();
        $attr['customer_id'] = $request->customer;

        if ($request->file('file') && $request->file('file')->isValid()) {
            $filename = Str::slug($request->kode) . '-' . time() . '.' . $request->file->extension();

            // upload file
            // public/spal/
            $request->file->move(public_path('/spal'), $filename);

            $attr['file'] = $filename;
        }

        Spal::create($attr);

        Alert::success('Tambah Data', 'Berhasil');

        return redirect()->route('spal.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale\Spal  $spal
     * @return \Illuminate\Http\Response
     */
    public function edit(Spal $spal)
    {
        return view('sale.spal.edit', compact('spal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale\Spal  $spal
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSpalRequest $request, Spal $spal)
    {
        $attr = $request->validated();
        $attr['customer_id'] = $request->customer;

        if ($request->file('file') && $request->file('file')->isValid()) {
            $filename = Str::slug($request->kode) . '-' . time() . '.' . $request->file->extension();

            // hapus file lama
            unlink(public_path("/spal/$spal->file"));

            // upload file baru
            $request->file->move(public_path('/spal'), $filename);

            $attr['file'] = $filename;
        }

        $spal->update($attr);

        Alert::success('Update Data', 'Berhasil');

        return redirect()->route('spal.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale\Spal  $spal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Spal $spal)
    {
        try {
            // hapus file
            unlink(public_path("/spal/$spal->file"));

            // baru hapus record
            $spal->delete();

            Alert::success('Hapus Data', 'Berhasil');

            return redirect()->route('spal.index');
        } catch (\Throwable $th) {
            Alert::error('Hapus Data', 'Gagal');

            return redirect()->route('spal.index');
        }
    }

    public function downloadFileSpal($filename)
    {
        $path = public_path() . "/spal/$filename";

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
