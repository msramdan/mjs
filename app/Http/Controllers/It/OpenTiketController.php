<?php

namespace App\Http\Controllers\It;

use App\Http\Controllers\Controller;
use App\Models\It\OpenTiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OpenTiketController extends Controller
{


    public function __construct()
    {
        $this->middleware('permission:view open tiket')->only('index');
        $this->middleware('permission:create open tiket')->only('create', 'store');
        $this->middleware('permission:edit open tiket')->only('edit', 'update');
        $this->middleware('permission:delete open tiket')->only('delete');
    }


    public function index()
    {

        if (auth()->user()->id == 1) {
            $data = DB::table('open_tiket')
                ->select('open_tiket.*', 'users.name')
                ->join('users', 'users.id', '=', 'open_tiket.user_id')
                ->get();
        } else {
            $data = DB::table('open_tiket')
                ->select('open_tiket.*', 'users.name')
                ->join('users', 'users.id', '=', 'open_tiket.user_id')
                ->where('user_id', auth()->user()->id)
                ->get();
        }
        return view('it.open_tiket.index', [
            'open_tiket' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('it.open_tiket.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $validator = Validator::make(
            $request->all(),
            [
                'judul' => "required|string",
                'pesan' => "required|string",
                'photo' => "required",
                'status' => "required"
            ],
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        //upload photo
        $photo = $request->file('photo');
        $photo->storeAs('public/it/open_tiket', $photo->hashName());

        $tiket = OpenTiket::create([
            'photo'     => $photo->hashName(),
            'user_id'     => auth()->user()->id,
            'judul'     => $request->judul,
            'pesan'   => $request->pesan,
            'status'   => $request->status
        ]);

        if ($tiket) {
            Alert::toast('Tambah data berhasil', 'success');
            return redirect()->route('open_tiket.index');
        } else {
            Alert::toast('Tambah data gagal', 'error');
            return redirect()->route('open_tiket.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OpenTiket  $openTiket
     * @return \Illuminate\Http\Response
     */
    public function show(OpenTiket $openTiket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OpenTiket  $openTiket
     * @return \Illuminate\Http\Response
     */
    public function edit(OpenTiket $openTiket)
    {

        $data = OpenTiket::findOrFail($openTiket->id);
        return view('it.open_tiket.edit', [
            'data' => $data
        ]);
    }

    public function update(Request $request, OpenTiket $openTiket)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'judul' => "required|string",
                'pesan' => "required|string",
                'photo' => 'image|mimes:png,jpg,jpeg,webp',
                // 'status' => "required"
            ],
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        $openTiket = OpenTiket::findOrFail($openTiket->id);

        if ($request->file('photo') == "") {
            $openTiket->update([
                // 'user_id'     => auth()->user()->id,
                'judul'     => $request->judul,
                'pesan'   => $request->pesan,
                'status'   => $request->status

            ]);
        } else {
            if ($request->file('photo') != "") {
                //hapus old photo
                $openTiket->delete_photo();
                //upload new photo
                $photo = $request->file('photo');
                $photo->storeAs('public/it/open_tiket', $photo->hashName());
                $openTiket->update([
                    'photo'     => $photo->hashName(),
                ]);
            }
            $openTiket->update([
                // 'user_id'     => auth()->user()->id,
                'judul'     => $request->judul,
                'pesan'   => $request->pesan,
                'status'   => $request->status

            ]);
        }
        if ($openTiket) {
            //redirect dengan pesan sukses
            Alert::toast('Data berhasil diupdate', 'success');
            return redirect()->route('open_tiket.index');
        } else {
            //redirect dengan pesan error
            Alert::toast('Data gagal diupdate', 'error');
            return redirect()->route('open_tiket.index');
        }
    }

    public function destroy(OpenTiket $openTiket)
    {
        $openTiket = OpenTiket::findOrFail($openTiket->id);
        $openTiket->delete_photo();
        $openTiket->delete();
        if ($openTiket) {
            Alert::toast('Data berhasil dihapus', 'success');
            return redirect()->route('open_tiket.index');
        } else {
            Alert::toast('Data gagal dihapus', 'error');
            return redirect()->route('open_tiket.index');
        }
    }

    public function download($id)
    {
        $OpenTiket = OpenTiket::findOrFail($id);
        $file = public_path() . '/storage/it/open_tiket/' . $OpenTiket->photo;
        return response()->download($file, $OpenTiket->photo);
    }
}
