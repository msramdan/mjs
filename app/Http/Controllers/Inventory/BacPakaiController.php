<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\StoreBacPakaiRequest;
use App\Http\Requests\Inventory\UpdateBacPakaiRequest;
use App\Models\Inventory\BacPakai;
use App\Models\Inventory\DetailBacPakai;
use App\Models\Inventory\FileBacPakai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class BacPakaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = BacPakai::with('user:id,name');

            return DataTables::of($query)
                ->addColumn('user', function ($row) {
                    return $row->user->name;
                })
                ->addColumn('tanggal', function ($row) {
                    return $row->tanggal->format('d M Y');
                })
                ->addColumn('action', 'inventory.bac-pakai._action')
                ->toJson();
        }

        return view('inventory.bac-pakai.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $show = false;
        $bacPakai = false;

        return view('inventory.bac-pakai.create', compact('show', 'bacPakai'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBacPakaiRequest $request)
    {
        DB::transaction(function () use ($request) {
            $bacPakai = BacPakai::create([
                'kode' => $request->kode,
                'user_id' => auth()->id(),
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
            ]);

            foreach ($request->produk as $i => $prd) {
                $detailBac[] = new DetailBacPakai([
                    'item_id' => $prd,
                    'qty' => $request->qty[$i],
                ]);
            }

            foreach ($request->file as $key => $file) {
                $filename[$key] = Str::slug($request->nama[$key]) . '-' . time() . '.' . $file->extension();

                $file->move(public_path('/bac-pakai'), $filename[$key]);

                $fileBac[] = new FileBacPakai([
                    'nama' => $request->nama[$key],
                    'file' => $filename[$key]
                ]);
            }

            $bacPakai->detail_bac_pakai()->saveMany($detailBac);

            $bacPakai->file_bac_pakai()->saveMany($fileBac);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory\BacPakai  $bacPakai
     * @return \Illuminate\Http\Response
     */
    public function show(BacPakai $bacPakai)
    {
        $show = true;

        $bacPakai->load(
            'user:id,name',
            'detail_bac_pakai',
            'detail_bac_pakai.item:id,unit_id,kode,nama,stok',
            'detail_bac_pakai.item.unit:id,nama',
            'file_bac_pakai:id,bac_pakai_id,nama,file'
        );

        return view('inventory.bac-pakai.show', compact('bacPakai', 'show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory\BacPakai  $bacPakai
     * @return \Illuminate\Http\Response
     */
    public function edit(BacPakai $bacPakai)
    {
        $show = false;

        $bacPakai->load(
            'user:id,name',
            'detail_bac_pakai',
            'detail_bac_pakai.item:id,unit_id,kode,nama,stok',
            'detail_bac_pakai.item.unit:id,nama',
            'file_bac_pakai:id,bac_pakai_id,nama,file'
        );

        return view('inventory.bac-pakai.edit', compact('bacPakai', 'show'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory\BacPakai  $bacPakai
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBacPakaiRequest $request, BacPakai $bacPakai)
    {
        $bacPakai->load(
            'user:id,name',
            'detail_bac_pakai',
            'detail_bac_pakai.item:id,unit_id,kode,nama,stok',
            'detail_bac_pakai.item.unit:id,nama',
            'file_bac_pakai:id,bac_pakai_id,nama,file'
        );

        DB::transaction(function () use ($request, $bacPakai) {
            // hapus data lama
            $bacPakai->detail_bac_pakai()->delete();

            // insert data baru
            $bacPakai->update([
                'kode' => $request->kode,
                'user_id' => auth()->id(),
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
            ]);

            foreach ($request->produk as $i => $prd) {
                $detailBac[] = new DetailBacPakai([
                    'item_id' => $prd,
                    'qty' => $request->qty[$i],
                ]);
            }

            if ($request->file) {
                // hapus file lama
                foreach ($bacPakai->file_bac_pakai as $detail) {
                    unlink(public_path("/bac-pakai/$detail->file"));
                }

                $bacPakai->file_bac_pakai()->delete();

                // inser file baru
                foreach ($request->file as $key => $file) {
                    $filename[$key] = Str::slug($request->nama[$key]) . '-' . time() . '.' . $file->extension();

                    $file->move(public_path('/bac-pakai'), $filename[$key]);

                    $fileBac[] = new FileBacPakai([
                        'nama' => $request->nama[$key],
                        'file' => $filename[$key]
                    ]);
                }

                $bacPakai->file_bac_pakai()->saveMany($fileBac);
            }

            $bacPakai->detail_bac_pakai()->saveMany($detailBac);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory\BacPakai  $bacPakai
     * @return \Illuminate\Http\Response
     */
    public function destroy(BacPakai $bacPakai)
    {
        $bacPakai->load('file_bac_pakai');

        // hapus file lama
        foreach ($bacPakai->file_bac_pakai as $detail) {
            unlink(public_path("/bac-pakai/$detail->file"));
        }

        $bacPakai->file_bac_pakai()->delete();

        $bacPakai->detail_bac_pakai()->delete();

        $bacPakai->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return redirect()->route('bac-pakai.index');
    }

    /**
     * Download the specified file from storage.
     *
     * @param  String $filename
     * @return \Illuminate\Http\Response
     */
    public function download($filename)
    {
        $path = public_path() . "/bac-pakai/$filename";

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

        $kode = 'BACP-' . $tahun . '-' . $bulan . '-' . $hari  . '-';

        $checkLatestKode = BacPakai::select('id', 'tanggal', 'kode')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->whereDay('tanggal', $hari)
            ->latest()
            ->first();

        if ($checkLatestKode == null) {
            $kode = $kode . '0001';
        } else {
            // hapus "BACP-XXXX-XX-XX-" dan ambil angka buat ditambahin
            // $onlyNumberKode = intval(Str::after($checkLatestKode->kode, $kode));
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

    public function getBacById($id)
    {
        abort_if(!request()->ajax(), 403);

        return BacPakai::with(
            'detail_bac_pakai:bac_pakai_id,id,item_id,qty,qty_validasi',
            'detail_bac_pakai.item:unit_id,id,nama,kode',
            'detail_bac_pakai.item.unit:id,nama',
            'file_bac_pakai:bac_pakai_id,id,nama,file',
            'user:id,name'
        )->findOrFail($id);
    }
}
