<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\{UpdateBacTerimaRequest, StoreBacTerimaRequest};
use App\Models\Inventory\{BacTerima, DetailBacTerima, FileBacTerima};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class BacTerimaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = BacTerima::with('user:id,name');

            return DataTables::of($query)
                ->addColumn('user', function ($row) {
                    return $row->user->name;
                })
                ->addColumn('tanggal', function ($row) {
                    return $row->tanggal->format('d M Y');
                })
                ->addColumn('action', 'inventory.bac-terima._action')
                ->toJson();
        }

        return view('inventory.bac-terima.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $show = false;
        $bacTerima = false;

        return view('inventory.bac-terima.create', compact('show', 'bacTerima'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBacTerimaRequest $request)
    {
        DB::transaction(function () use ($request) {
            $bacTerima = BacTerima::create([
                'kode' => $request->kode,
                'user_id' => auth()->id(),
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
            ]);

            foreach ($request->produk as $i => $prd) {
                $detailBac[] = new DetailBacTerima([
                    'item_id' => $prd,
                    'qty' => $request->qty[$i],
                ]);
            }

            foreach ($request->file as $key => $file) {
                $filename[$key] = Str::slug($request->nama[$key]) . '-' . time() . '.' . $file->extension();

                $file->move(public_path('/bac-terima'), $filename[$key]);

                $fileBac[] = new FileBacTerima([
                    'nama' => $request->nama[$key],
                    'file' => $filename[$key]
                ]);
            }

            $bacTerima->detail_bac_terima()->saveMany($detailBac);

            $bacTerima->file_bac_terima()->saveMany($fileBac);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory\BacTerima  $bacTerima
     * @return \Illuminate\Http\Response
     */
    public function show(BacTerima $bacTerima)
    {
        $show = true;

        $bacTerima->load(
            'user:id,name',
            'detail_bac_terima',
            'detail_bac_terima.item:id,unit_id,kode,nama,stok',
            'detail_bac_terima.item.unit:id,nama',
            'file_bac_terima:id,bac_terima_id,nama,file'
        );

        return view('inventory.bac-terima.show', compact('bacTerima', 'show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory\BacTerima  $bacTerima
     * @return \Illuminate\Http\Response
     */
    public function edit(BacTerima $bacTerima)
    {
        $show = false;

        $bacTerima->load(
            'user:id,name',
            'detail_bac_terima',
            'detail_bac_terima.item:id,unit_id,kode,nama,stok',
            'detail_bac_terima.item.unit:id,nama',
            'file_bac_terima:id,bac_terima_id,nama,file'
        );

        return view('inventory.bac-terima.edit', compact('bacTerima', 'show'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory\BacTerima  $bacTerima
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBacTerimaRequest $request, BacTerima $bacTerima)
    {
        $bacTerima->load(
            'user:id,name',
            'detail_bac_terima',
            'detail_bac_terima.item:id,unit_id,kode,nama,stok',
            'detail_bac_terima.item.unit:id,nama',
            'file_bac_terima:id,bac_terima_id,nama,file'
        );

        DB::transaction(function () use ($request, $bacTerima) {
            // hapus data lama
            $bacTerima->detail_bac_terima()->delete();

            // insert data baru
            $bacTerima->update([
                'kode' => $request->kode,
                'user_id' => auth()->id(),
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
            ]);

            foreach ($request->produk as $i => $prd) {
                $detailBac[] = new DetailBacTerima([
                    'item_id' => $prd,
                    'qty' => $request->qty[$i],
                ]);
            }

            if ($request->file) {
                // hapus file lama
                foreach ($bacTerima->file_bac_terima as $detail) {
                    unlink(public_path("/bac-terima/$detail->file"));
                }

                $bacTerima->file_bac_terima()->delete();

                // insert file baru
                foreach ($request->file as $key => $file) {
                    $filename[$key] = Str::slug($request->nama[$key]) . '-' . time() . '.' . $file->extension();

                    $file->move(public_path('/bac-terima'), $filename[$key]);

                    $fileBac[] = new FileBacTerima([
                        'nama' => $request->nama[$key],
                        'file' => $filename[$key]
                    ]);
                }

                $bacTerima->file_bac_terima()->saveMany($fileBac);
            }

            $bacTerima->detail_bac_terima()->saveMany($detailBac);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory\BacTerima  $bacTerima
     * @return \Illuminate\Http\Response
     */
    public function destroy(BacTerima $bacTerima)
    {
        $bacTerima->load('file_bac_terima');

        // hapus file lama
        foreach ($bacTerima->file_bac_terima as $detail) {
            unlink(public_path("/bac-terima/$detail->file"));
        }

        $bacTerima->file_bac_terima()->delete();

        $bacTerima->detail_bac_terima()->delete();

        $bacTerima->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return redirect()->route('bac-terima.index');
    }

    /**
     * Download the specified file from storage.
     *
     * @param  String $filename
     * @return \Illuminate\Http\Response
     */
    public function download($filename)
    {
        $path = public_path() . "/bac-terima/$filename";

        $extension = \File::extension($filename);

        $headers = array(
            // type sesuai extension file
            'Content-Type: application/' . $extension,
        );

        /**
         * params
         * 1: document file,
         * 2: nama file ketika didownload,
         * 3:header(optional, default: pdf)
         */
        return response()->download($path, $filename, $headers);
    }

    /**
     * Generate unique & auto increment code by date.
     *
     * @param  String $tanggal
     * @return \Illuminate\Http\Response
     */
    public function generateKode($tanggal)
    {
        // kalo diakses lewat browser/url/bukan ajax
        abort_if(!request()->ajax(), 403);

        $tahun = date('Y', strtotime($tanggal));
        $bulan = date('m', strtotime($tanggal));
        $hari = date('d', strtotime($tanggal));

        $kode = 'BACT-' . $tahun . '-' . $bulan . '-' . $hari  . '-';

        $checkLatestKode = BacTerima::select('id', 'tanggal', 'kode')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->whereDay('tanggal', $hari)
            ->latest()
            ->first();

        if ($checkLatestKode == null) {
            $kode = $kode . '0001';
        } else {
            // hapus "BACT-XXXX-XX-XX-" dan ambil angka buat ditambahin
            $onlyNumberKode = intval(substr($checkLatestKode->kode, -4));

            if ($onlyNumberKode < 100) {
                $kode = $kode . '000' . ($onlyNumberKode + 1);
            } elseif ($onlyNumberKode >= 100 && $onlyNumberKode < 1000) {
                $kode =  $kode . '0' . ($onlyNumberKode + 1);
            } else {
                $kode = $kode . ($onlyNumberKode + 1);
            }
        }

        return response()->json(['kode' => $kode], 200);
    }
}
