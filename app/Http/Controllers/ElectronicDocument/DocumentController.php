<?php

namespace App\Http\Controllers\ElectronicDocument;

use App\Http\Controllers\Controller;
use App\Http\Requests\ElectronicDocument\{StoreDocumentRequest, UpdateDocumentRequest};
use App\Models\ElectronicDocument\Document;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Document::with('category_document:id,nama')->latest('updated_at');

            return DataTables::of($query)
                ->addColumn('category_document', function ($row) {
                    return $row->category_document->nama;
                })
                ->addColumn('tanggal_buat', function ($row) {
                    return $row->tanggal_buat->format('d M Y');
                })
                ->addColumn('tanggal_expired', function ($row) {
                    return $row->tanggal_expired->format('d M Y');
                })
                ->addColumn('action', 'electronic-document.document._action')
                ->toJson();
        }

        return view('electronic-document.document.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('electronic-document.document.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDocumentRequest $request)
    {
        $attr = $request->validated();
        $attr['category_document_id'] = $request->category_document;

        if ($request->file('file') && $request->file('file')->isValid()) {
            $filename = Str::slug($request->nama) . '-' . time() . '.' . $request->file->extension();

            // upload file
            // public/document/
            $request->file->move(public_path('/document'), $filename);

            $attr['file'] = $filename;
        }

        Document::create($attr);

        Alert::success('Tambah Data', 'Berhasil');

        return redirect()->route('document.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ElectronicDocument\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        return view('electronic-document.document.edit', compact('document'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ElectronicDocument\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDocumentRequest $request, Document $document)
    {
        $attr = $request->validated();
        $attr['category_document_id'] = $request->category_document;

        if ($request->file('file') && $request->file('file')->isValid()) {
            $filename = Str::slug($request->nama) . '-' . time() . '.' . $request->file->extension();

            // hapus file
            unlink(public_path("/document/$document->file"));

            // upload file
            // public/document/
            $request->file->move(public_path('/document'), $filename);

            $attr['file'] = $filename;
        }

        $document->update($attr);

        Alert::success('Update Data', 'Berhasil');

        return redirect()->route('document.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ElectronicDocument\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        // hapus file
        unlink(public_path("/document/$document->file"));

        // baru hapus record
        $document->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return redirect()->route('document.index');
    }

    /**
     * Download the specified file/document from storage.
     *
     * @param  String $filename
     * @return \Illuminate\Http\Response
     */
    public function download($filename)
    {
        $path = public_path() . "/document/$filename";

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
