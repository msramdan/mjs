<?php

namespace App\Http\Controllers\Accouting;

use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Accounting\DocumentAccounting;
use App\Http\Requests\Accounting\{StoreDocumentAccountingRequest, UpdateDocumentAccountingRequest};

class DocumentAccountingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view document accounting')->only('index', 'download');
        $this->middleware('permission:create document accounting')->only('create', 'store');
        $this->middleware('permission:edit document accounting')->only('edit', 'update');
        $this->middleware('permission:delete document accounting')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = DocumentAccounting::query();

        if (request()->ajax()) {
            return DataTables::of($query)
                ->addColumn('file', function ($row) {
                    return '<a href="' . route('document-accounting.download', $row->file) . '" target="_blank">
                        <i class="fas fa-download"></i>
                    </a>';
                })
                ->addColumn('action', 'accounting.document-accounting._action')
                ->rawColumns(['file', 'action'])
                ->toJson();
        }

        return view('accounting.document-accounting.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounting.document-accounting.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDocumentAccountingRequest $request)
    {
        $attr = $request->validated();

        if ($request->file('file') && $request->file('file')->isValid()) {
            $filename = $request->file->hashName();

            $request->file('file')->move(public_path('/accounting'), $filename);

            $attr['file'] = $filename;
        }

        DocumentAccounting::create($attr);

        Alert::toast('Tambah data berhasil', 'success');

        return redirect()->route('document-accounting.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $documentAccounting = DocumentAccounting::findOrFail($id);

        return view('accounting.document-accounting.edit', compact('documentAccounting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDocumentAccountingRequest $request, int $id)
    {
        $documentAccounting = DocumentAccounting::findOrFail($id);
        $attr = $request->validated();
        $attr['file'] = $documentAccounting->file;

        if ($request->file('file') && $request->file('file')->isValid()) {
            $filename = $request->file->hashName();

            $request->file('file')->move(public_path('/accounting'), $filename);

            // delete old file from storage
            if ($documentAccounting->file != null && file_exists(public_path("accounting/$documentAccounting->file"))) {
                unlink(public_path("accounting/$documentAccounting->file"));
            }

            $attr['file'] = $filename;
        }

        $documentAccounting->update($attr);

        Alert::toast('Update data berhasil', 'success');

        return redirect()->route('document-accounting.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $documentAccounting = DocumentAccounting::findOrFail($id);

        // delete old file from storage
        if ($documentAccounting->file != null && file_exists(public_path("accounting/$documentAccounting->file"))) {
            unlink(public_path("accounting/$documentAccounting->file"));
        }

        $documentAccounting->delete();

        Alert::toast('Hapus data berhasil', 'success');

        return redirect()->route('document-accounting.index');
    }

    /**
     * Download the specified file from storage.
     *
     * @param string $filename
     * @return \Illuminate\Http\Response
     */
    public function download(string $filename)
    {
        if (file_exists($path = public_path("accounting/$filename"))) {
            $headers = array(
                // type sesuai extension file
                'Content-Type: application/' . \File::extension($filename),
            );

            return response()->download($path, $filename, $headers);
        } else {
            abort(404, "File doesn't exist");
        }
    }
}
