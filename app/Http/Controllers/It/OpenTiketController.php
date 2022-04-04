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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(auth()->user()->id==1){
            $data = DB::table('open_tiket')
            ->select('open_tiket.*', 'users.name')
            ->join('users', 'users.id', '=', 'open_tiket.user_id')
            ->get();
        }else{
            $data = DB::table('open_tiket')
            ->select('open_tiket.*', 'users.name')
            ->join('users', 'users.id', '=', 'open_tiket.user_id')
            ->where('user_id',auth()->user()->id)
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
        $photo->storeAs('public/it', $photo->hashName());

        $tiket = OpenTiket::create([
            'photo'     => $photo->hashName(),
            'user_id'     => auth()->user()->id,
            'judul'     => $request->judul,
            'pesan'   => $request->pesan,
            'status'   => $request->status
        ]);

        if($tiket){
            Alert::toast('Tambah data berhasil', 'success');
            return redirect()->route('open_tiket.index');
        }else{
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OpenTiket  $openTiket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OpenTiket $openTiket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OpenTiket  $openTiket
     * @return \Illuminate\Http\Response
     */
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
}
