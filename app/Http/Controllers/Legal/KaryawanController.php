<?php

namespace App\Http\Controllers\Legal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Legal\StoreKaryawanRequest;
use App\Http\Requests\Legal\UpdateKaryawanRequest;
use App\Models\Legal\Karyawan;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Karyawan::with('divisi:id,nama', 'jabatan:id,nama', 'status_karyawan:id,nama', 'lokasi:id,nama')->latest('updated_at');

            return Datatables::of($query)
                ->addColumn('foto', function ($row) {
                    if ($row->foto != null) {
                        return asset('storage/img/karyawan/' . $row->foto);
                    } else {
                        return "https://www.gravatar.com/avatar/" . md5(strtolower(trim($row->email))) . "&s=100";
                    }
                })
                ->addColumn('divisi', function ($row) {
                    return $row->divisi->nama;
                })
                ->addColumn('jabatan', function ($row) {
                    return $row->jabatan->nama;
                })
                ->addColumn('status_karyawan', function ($row) {
                    return $row->status_karyawan->nama;
                })
                // susah buat ditampilin di input:date
                ->addColumn('tgl_masuk', function ($row) {
                    return $row->tgl_masuk->format('d M Y');
                })
                ->addColumn('action', 'legal.karyawan._action')
                ->toJson();
        }

        return view('legal.karyawan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('legal.karyawan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKaryawanRequest $request)
    {
        $attr = $request->validated();
        $attr['divisi_id'] = $request->divisi;
        $attr['jabatan_id'] = $request->jabatan;
        $attr['status_karyawan_id'] = $request->status_karyawan;
        $attr['lokasi_id'] = $request->lokasi;

        if ($request->file('foto') && $request->file('foto')->isValid()) {
            $filename = time()  . '.' . $request->foto->extension();

            $request->foto->storeAs('public/img/karyawan/', $filename);

            $attr['foto'] = $filename;
        }

        Karyawan::create($attr);

        Alert::success('Tambah Data', 'Berhasil');

        return redirect()->route('karyawan.index');
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Legal\Karyawan  $karyawan
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(Karyawan $karyawan)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Legal\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function edit(Karyawan $karyawan)
    {
        // $karyawan->load('divisi:id,nama', 'jabatan:id,nama', 'status_karyawan:id,nama', 'lokasi:id,nama');

        return view('legal.karyawan.edit', compact('karyawan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Legal\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKaryawanRequest $request, Karyawan $karyawan)
    {
        $attr = $request->validated();
        $attr['divisi_id'] = $request->divisi;
        $attr['jabatan_id'] = $request->jabatan;
        $attr['status_karyawan_id'] = $request->status_karyawan;
        $attr['lokasi_id'] = $request->lokasi;

        if ($request->file('foto') && $request->file('foto')->isValid()) {
            $filename = time()  . '.' . $request->foto->extension();

            $request->foto->storeAs('public/img/karyawan/', $filename);

            // delete old foto from storage
            Storage::delete('public/img/karyawan/' . $karyawan->foto);

            $attr['foto'] = $filename;
        }

        $karyawan->update($attr);

        Alert::success('Update Data', 'Berhasil');

        return redirect()->route('karyawan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Legal\Karyawan  $karyawan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Karyawan $karyawan)
    {
        // delete old foto from storage
        Storage::delete('public/img/karyawan/' . $karyawan->foto);

        // hapus file
        foreach ($karyawan->berkas_karyawan as $detail) {
            unlink(public_path("/berkas-karyawan/$detail->file"));
        }

        $karyawan->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return redirect()->route('karyawan.index');
    }
}
