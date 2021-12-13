<?php

namespace App\Http\Controllers\Legal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Legal\StoreBerkasKaryawanRequest;
use App\Http\Requests\Legal\UpdateBerkasKaryawanRequest;
use App\Models\Legal\BerkasKaryawan;
use App\Models\Legal\Karyawan;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class BerkasKaryawanController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $karyawan = Karyawan::select('id', 'nama')
            ->withCount('berkas_karyawan')
            ->with('berkas_karyawan')
            ->findOrFail(request('karyawan'));

        return view('legal.berkas.create', compact('karyawan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBerkasKaryawanRequest $request)
    {
        $karyawan = Karyawan::findOrFail($request->karyawan);

        DB::transaction(function () use ($request, $karyawan) {
            $detailBerkas = [];
            foreach ($request->nama as $key => $value) {
                $filename[$key] = Str::slug($value) . '-' . time() . '.' . $request->file[$key]->extension();

                $request->file[$key]->move(public_path('/berkas-karyawan'), $filename[$key]);

                $detailBerkas[] = [
                    'karyawan_id' => $karyawan->id,
                    'nama' => $value,
                    'file' => $filename[$key],
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(),
                ];
            }

            DB::table('berkas_karyawan')->insert($detailBerkas);

            Alert::success('Tambah Berkas', 'Berhasil');
        });

        return redirect()->route('karyawan.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Legal\BerkasKaryawan  $berkasKaryawan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBerkasKaryawanRequest $request, $id)
    {
        $karyawan = Karyawan::findOrFail($request->karyawan);

        DB::transaction(function () use ($request, $karyawan) {

            $detailBerkas = [];

            if ($request->file) {
                foreach ($request->file as $key => $value) {
                    $filename[$key] = Str::limit(Str::slug($request->nama[$key]), 20) . '-' . time() . '.' . $request->file[$key]->extension();

                    $request->file[$key]->move(public_path('/berkas-karyawan'), $filename[$key]);

                    $detailBerkas[] = [
                        'karyawan_id' => $karyawan->id,
                        'nama' => $request->nama[$key],
                        'file' => $filename[$key],
                        'created_at' => now()->toDateTimeString(),
                        'updated_at' => now()->toDateTimeString(),
                    ];
                }

                // hapus file
                foreach ($karyawan->berkas_karyawan as $detail) {
                    unlink(public_path("/berkas-karyawan/$detail->file"));
                }

                // hapus dari database
                $karyawan->berkas_karyawan()->delete();
            }

            DB::table('berkas_karyawan')->insert($detailBerkas);

            Alert::success('Update Berkas', 'Berhasil');
        });

        return redirect()->route('karyawan.index');
    }

    /**
     * Download the specified file from storage.
     *
     * @param  String $filename
     * @return \Illuminate\Http\Response
     */
    public function download($filename)
    {
        $path = public_path() . "/berkas-karyawan/$filename";

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
}
