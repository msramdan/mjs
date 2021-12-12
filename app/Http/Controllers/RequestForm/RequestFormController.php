<?php

namespace App\Http\Controllers\RequestForm;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestForm\StoreRequestFormRequest;
use App\Http\Requests\RequestForm\UpdateRequestFormRequest;
use App\Models\RequestForm\DetailRequestForm;
use App\Models\RequestForm\RequestForm;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class RequestFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = RequestForm::with('category_request:id,nama')->latest('updated_at');

            return DataTables::of($query)
                ->addColumn('category_request', function ($row) {
                    return $row->category_request->nama;
                })
                ->addColumn('user', function ($row) {
                    return $row->user->name;
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
        return view('form-request.form.create');
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

            $requestForm->detail_request_form()->saveMany($detailRequestForm);

            Alert::success('Tambah Data', 'Berhasil');
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
        $requestForm->load('detail_request_form', 'category_request');

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
        $requestForm->load('detail_request_form');

        return view('form-request.form.edit', compact('requestForm'));
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
        DB::transaction(function () use ($request, $requestForm) {
            $attr = $request->validated();
            $attr['category_request_id'] = $request->category_request;
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

                    // unlink(public_path("/form-request/$requestForm->detail_request_form[$key]->file"));
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

            Alert::success('Update Data', 'Berhasil');
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
        // hapus file
        foreach ($requestForm->detail_request_form as $detail) {
            unlink(public_path("/form-request/$detail->file"));
        }

        // baru hapus record
        $requestForm->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return redirect()->route('request-form.index');
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
}
