<?php

namespace App\Http\Controllers\RequestForm;

use App\Http\Controllers\Controller;
use App\Models\Master\Lokasi;
use App\Http\Requests\RequestForm\{StoreRequestFormRequest, UpdateRequestFormRequest};
use App\Models\Master\SettingCategoryRequest;
use App\Models\RequestForm\{DetailRequestForm, StatusRequestForm, RequestForm};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class RequestFormController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view request form purchase')->only('index', 'show');
        $this->middleware('permission:create request form purchase')->only('create', 'store');
        $this->middleware('permission:edit request form purchase')->only('edit', 'update');
        $this->middleware('permission:delete request form purchase')->only('delete');
        $this->middleware('permission:approve request form purchase')->only('setStatus');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = RequestForm::with('category_request:id,nama', 'user:id,name', 'lokasi:id,nama');

            return DataTables::of($query)
                ->addColumn('category_request', function ($row) {
                    return $row->category_request->nama;
                })
                ->addColumn('user', function ($row) {
                    return $row->user->name;
                })
                ->addColumn('lokasi', function ($row) {
                    return $row->lokasi->nama;
                })

                ->addColumn('tanggal', function ($row) {
                    return $row->tanggal->format('d M Y');
                })
                ->addColumn('action', 'form-request.form._action')
                ->toJson();
        }

        return view('form-request.form.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lokasi = Lokasi::all();
        return view('form-request.form.create', [
            'lokasi' => $lokasi
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequestFormRequest $request)
    {
        DB::transaction(function () use ($request) {
            $attr = $request->validated();
            $attr['category_request_id'] = $request->category_request;
            $attr['lokasi_id'] = $request->lokasi_id;
            $attr['user_id'] = auth()->id();


            $detailRequestForm = [];
            foreach ($request->nama as $key => $value) {
                $filename[$key] = Str::slug($value) . '-' . time() . '.' . $request->file[$key]->extension();

                $request->file[$key]->move(public_path('/form-request'), $filename[$key]);

                $detailRequestForm[] = new DetailRequestForm([
                    'nama' => $value,
                    'file' => $filename[$key]
                ]);
            }

            $requestForm = RequestForm::create($attr);

            // get setting cateogry, insert and set status to waiting
            $settingCategory = SettingCategoryRequest::where('category_request_id', $request->category_request)->get();

            if (isset($settingCategory)) {
                foreach ($settingCategory as $sc) {
                    DB::table('status_request_forms')->insert([
                        [
                            'request_form_id' => $requestForm->id,
                            'setting_category_request_form_id' => $sc->id,
                            'status' => 'Waiting',
                            'created_at' => now()->toDateTimeString(),
                            'updated_at' => now()->toDateTimeString(),
                        ]
                    ]);
                }
            }

            // $requestForm->status_request_forms()->saveMany($insertSC);

            $requestForm->detail_request_form()->saveMany($detailRequestForm);

            Alert::toast('Tambah data berhasil', 'success');
        });

        return redirect()->route('request-form.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RequestForm\RequestForm  $requestForm
     * @return \Illuminate\Http\Response
     */
    public function show(RequestForm $requestForm)
    {
        $requestForm->load(
            'detail_request_form:id,request_form_id,nama,file',
            'status_request_forms',
            'status_request_forms.setting_category_request:id,category_request_id,user_id,step',
            'status_request_forms.setting_category_request.user:id,name,foto',
            'category_request:id,kode,nama',
        );

        return view('form-request.form.show', compact('requestForm'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RequestForm\RequestForm  $requestForm
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestForm $requestForm)
    {

        $lokasi = Lokasi::all();


        $requestForm->load(
            'status_request_forms',
            'detail_request_form:id,request_form_id,nama,file',
            'status_request_forms.setting_category_request:id,category_request_id,user_id,step',
            'status_request_forms.setting_category_request.user:id,name,foto',
            'category_request:id,kode,nama',
        );

        return view('form-request.form.edit', [
            'requestForm' => $requestForm,
            'lokasi' => $lokasi
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RequestForm\RequestForm  $requestForm
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequestFormRequest $request, RequestForm $requestForm)
    {
        $requestForm->load('detail_request_form');

        DB::transaction(function () use ($request, $requestForm) {
            $attr = $request->validated();
            $attr['category_request_id'] = $request->category_request;
            $attr['lokasi_id'] = $request->lokasi_id;
            $attr['user_id'] = auth()->id();

            $detailRequestForm = [];
            if ($request->file) {
                foreach ($request->file as $key => $fileValue) {
                    $filename[$key] = Str::slug($request->nama[$key]) . '-' . time() . '.' . $fileValue->extension();

                    $fileValue->move(public_path('/form-request'), $filename[$key]);

                    $detailRequestForm[] = new DetailRequestForm([
                        'nama' => $request->nama[$key],
                        'file' => $filename[$key]
                    ]);
                }

                // hapus file
                foreach ($requestForm->detail_request_form as $detail) {
                    unlink(public_path("/form-request/$detail->file"));
                }

                // hapus record dari database
                $requestForm->detail_request_form()->delete();

                // insert detail baru
                $requestForm->detail_request_form()->saveMany($detailRequestForm);
            }

            // update
            $requestForm->update($attr);

            Alert::toast('Update data berhasil', 'success');
        });

        return redirect()->route('request-form.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RequestForm\RequestForm  $requestForm
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequestForm $requestForm)
    {
        try {

            $fileRequestForm = $requestForm->detail_request_form;

            // baru hapus record
            $requestForm->delete();

            // hapus file
            foreach ($fileRequestForm as $detail) {
                unlink(public_path("/form-request/$detail->file"));
            }

            Alert::toast('Hapus data berhasil', 'success');

            return redirect()->route('request-form.index');
        } catch (\Throwable $th) {
            Alert::toast('Hapus data gagal', 'error');

            return redirect()->route('request-form.index');
        }
    }

    /**
     * Download the specified file from storage.
     *
     * @param  String $filename
     * @return \Illuminate\Http\Response
     */
    public function download($filename)
    {
        $path = public_path() . "/form-request/$filename";

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

    public function getRequestFormById($id)
    {
        abort_if(!request()->ajax(), 403);

        return RequestForm::with('user:id,name', 'category_request:id,nama')->findOrFail($id);
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

        $kode = 'RF-' . $tahun . '-' . $bulan . '-' . $hari  . '-';

        $checkLatestKode = RequestForm::select('id', 'tanggal', 'kode')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->whereDay('tanggal', $hari)
            ->latest()
            ->first();

        if ($checkLatestKode == null) {
            $kode = $kode . '0001';
        } else {
            // hapus "RF-XXXX-XX-XX-" dan ambil angka buat ditambahin
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

    /**
     * Set status to approve or waiting.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setStatus(Request $request)
    {
        $statusRequest = StatusRequestForm::where([
            'setting_category_request_form_id' => $request->setting_category_request_form_id,
            'request_form_id' => $request->request_form_id
        ])->firstOrFail();

        $statusRequest->update(['status' => $request->status_rf]);

        Alert::toast('Status berhasil diubah', 'success');

        return redirect()->route('request-form.index');
    }
}
