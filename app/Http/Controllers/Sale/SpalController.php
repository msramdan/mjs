<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sale\{StoreSpalRequest, UpdateSpalRequest};
use App\Models\Sale\{Spal, FileSpal};
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class SpalController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view spal')->only('index', 'download');
        $this->middleware('permission:create spal')->only('create', 'store');
        $this->middleware('permission:edit spal')->only('edit', 'update');
        $this->middleware('permission:delete spal')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Spal::with('customer:id,nama');

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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSpalRequest $request)
    {
        $attr = $request->validated();
        $attr['customer_id'] = $request->customer;
        $attr['jml_muatan'] = $this->removeCommas($request->jml_muatan);
        $attr['harga_unit'] = $this->removeCommas($request->harga_unit);
        $attr['harga_demorage'] = $this->removeCommas($request->harga_demorage);

        $spal = Spal::create($attr);

        foreach ($request->file as $key => $file) {
            $filename[$key] = Str::slug($request->nama_file[$key]) . '-' . time() . '.' . $file->extension();

            $file->move(public_path('/spal'), $filename[$key]);

            $fileSpal[] = new FileSpal([
                'nama' => $request->nama_file[$key],
                'file' => $filename[$key]
            ]);
        }

        $spal->file_spal()->saveMany($fileSpal);

        Alert::toast('Tambah data berhasil', 'success');

        return redirect()->route('spal.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale\Spal $spal
     * @return \Illuminate\Http\Response
     */
    public function edit(Spal $spal)
    {
        $spal->load('file_spal');

        return view('sale.spal.edit', compact('spal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Sale\Spal $spal
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSpalRequest $request, Spal $spal)
    {
        $spal->load('file_spal');

        $attr = $request->validated();
        $attr['customer_id'] = $request->customer;
        $attr['jml_muatan'] = $this->removeCommas($request->jml_muatan);
        $attr['harga_unit'] = $this->removeCommas($request->harga_unit);
        $attr['harga_demorage'] = $this->removeCommas($request->harga_demorage);


        if ($request->file) {
            // hapus file lama
            foreach ($spal->file_spal as $detail) {
                unlink(public_path("/spal/$detail->file"));
            }

            $spal->file_spal()->delete();

            // inser file baru
            foreach ($request->file as $key => $file) {
                $filename[$key] = Str::slug($request->nama_file[$key]) . '-' . time() . '.' . $file->extension();

                $file->move(public_path('/spal'), $filename[$key]);

                $fileBac[] = new FileSpal([
                    'nama' => $request->nama_file[$key],
                    'file' => $filename[$key]
                ]);
            }

            $spal->file_spal()->saveMany($fileBac);
        }

        $spal->update($attr);

        Alert::toast('Update data berhasil', 'success');

        return redirect()->route('spal.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale\Spal $spal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Spal $spal)
    {
        try {
            // hapus file
            // hapus file lama
            foreach ($spal->file_spal as $detail) {
                unlink(public_path("/spal/$detail->file"));
            }
            // baru hapus record
            $spal->delete();

            Alert::toast('Hapus data berhasil', 'success');

            return redirect()->route('spal.index');
        } catch (\Throwable $th) {
            Alert::toast('Hapus data gagal', 'error');

            return redirect()->route('spal.index');
        }
    }

    /**
     * Download the specified file from storage.
     *
     * @param string $filename
     * @return \Illuminate\Http\Response
     */
    public function download(string $filename)
    {
        if (file_exists($path = public_path() . "/spal/$filename")) {
            $headers = array(
                // type sesuai extension file
                'Content-Type: application/' . \File::extension($filename),
            );

            return response()->download($path, $filename, $headers);
        } else {
            abort(404, "File doesn't exist");
        }
    }

    /**
     * Get spal with customer and time sheet by spal id.
     *
     * @param int $id
     * @return int
     */
    public function getSpalById(int $id)
    {
        abort_if(!request()->ajax(), 403);

        return Spal::select('id', 'customer_id', 'kode', 'nama_kapal', 'nama_muatan', 'jml_muatan', 'pelabuhan_muat', 'pelabuhan_bongkar', 'harga_unit', 'harga_demorage',)
            ->with('customer:id,nama', 'time_sheets:id,spal_id,qty,hari,jam,menit')
            ->findOrFail($id);
    }

    /**
     * Remove comma from string and convert to integer.
     *
     * @param string $number
     * @return int
     */
    protected function removeCommas(string $number)
    {
        return intval(preg_replace('/[^\d.]/', '', $number));
    }
}
