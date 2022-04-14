<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\StoreNewBacTerimaRequest;
use App\Http\Requests\Inventory\UpdateNewBacTerimaRequest;
use App\Models\Inventory\{NewBacTerima, NewFileBacTerima, NewDetailBacTerima};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class NewBacTerimaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view bac terima')->only('index', 'show', 'download');
        $this->middleware('permission:create bac terima')->only('create', 'store');
        $this->middleware('permission:edit bac terima')->only('edit', 'update');
        $this->middleware('permission:delete bac terima')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = NewBacTerima::with('user:id,name');

            return DataTables::of($query)
                ->addColumn('user', function ($row) {
                    return $row->user->name;
                })
                ->addColumn('action', 'inventory.new-bac-terima._action')
                ->toJson();
        }

        return view('inventory.new-bac-terima.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.new-bac-terima.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewBacTerimaRequest $request)
    {
        DB::transaction(function () use ($request) {
            $bac = NewBacTerima::create([
                'kode' => $request->kode,
                'user_id' => auth()->id(),
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
            ]);

            foreach ($request->produk as $i => $prd) {
                $detailBac[] = new NewDetailBacTerima([
                    'item_id' => $prd,
                    'qty_terima' => $request->qty_terima[$i],
                ]);
            }

            foreach ($request->file as $key => $file) {
                $filename[$key] = $file->hashName();

                $file->move(public_path('/bac-terima'), $filename[$key]);

                $fileBac[] = new NewFileBacTerima([
                    'nama' => $request->nama[$key],
                    'file' => $filename[$key]
                ]);
            }

            $bac->new_detail_bac_terima()->saveMany($detailBac);

            $bac->new_file_bac_terima()->saveMany($fileBac);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bac = NewBacTerima::with(
            'user:id,name',
            'new_detail_bac_terima',
            'new_detail_bac_terima.item:id,unit_id,kode,nama,stok',
            'new_detail_bac_terima.item.unit:id,nama',
            'new_file_bac_terima:id,new_bac_terima_id,nama,file'
        )->findOrFail($id);

        $show = true;

        return view('inventory.new-bac-terima.show', compact('bac', 'show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bac = NewBacTerima::with(
            'user:id,name',
            'new_detail_bac_terima',
            'new_detail_bac_terima.item:id,unit_id,kode,nama,stok',
            'new_detail_bac_terima.item.unit:id,nama',
            'new_file_bac_terima:id,new_bac_terima_id,nama,file'
        )->findOrFail($id);

        return view('inventory.new-bac-terima.edit', compact('bac'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNewBacTerimaRequest $request, $id)
    {
        $bac = NewBacTerima::with(
            'user:id,name',
            'new_detail_bac_terima',
            'new_detail_bac_terima.item:id,unit_id,kode,nama,stok',
            'new_detail_bac_terima.item.unit:id,nama',
            'new_file_bac_terima:id,new_bac_terima_id,nama,file'
        )->findOrFail($id);

        DB::transaction(function () use ($request, $bac) {
            // hapus data lama
            $bac->new_detail_bac_terima()->delete();

            // insert data baru
            $bac->update([
                'kode' => $request->kode,
                'user_id' => auth()->id(),
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
            ]);

            foreach ($request->produk as $i => $prd) {
                $detailBac[] = new NewDetailBacTerima([
                    'item_id' => $prd,
                    'qty_terima' => $request->qty_terima[$i],
                ]);
            }

            if ($request->file) {
                // hapus file lama
                foreach ($bac->file_bac_terima as $detail) {
                    unlink(public_path("/bac-terima/$detail->file"));
                }

                $bac->new_file_bac_terima()->delete();

                // inser file baru
                foreach ($request->file as $key => $file) {
                    $filename[$key] = $file->hashName();

                    $file->move(public_path('/bac-terima'), $filename[$key]);

                    $fileBac[] = new NewFileBacTerima([
                        'nama' => $request->nama[$key],
                        'file' => $filename[$key]
                    ]);
                }

                $bac->new_file_bac_terima()->saveMany($fileBac);
            }

            $bac->new_detail_bac_terima()->saveMany($detailBac);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bac = NewBacTerima::findOrFail($id);

        $bac->load('new_file_bac_terima');

        // hapus file lama
        foreach ($bac->new_file_bac_terima as $detail) {
            unlink(public_path("/bac-terima/$detail->file"));
        }

        $bac->delete();

        Alert::toast('Hapus data berhasil', 'success');

        return redirect()->route('new-bac-terima.index');
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

        $kode = 'NBACT-' . $tahun . '-' . $bulan . '-' . $hari  . '-';

        $checkLatestKode = NewBacTerima::select('id', 'tanggal', 'kode')
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

    public function getBacById($id)
    {
        abort_if(!request()->ajax(), 403);

        return NewBacTerima::with(
            // ,qty_validasi
            'new_detail_bac_terima:new_bac_terima_id,id,item_id,qty_terima',
            'new_detail_bac_terima.item:unit_id,id,nama,kode',
            'new_detail_bac_terima.item.unit:id,nama',
            'new_file_bac_terima:new_bac_terima_id,id,nama,file',
            'user:id,name'
        )->findOrFail($id);
    }
}
