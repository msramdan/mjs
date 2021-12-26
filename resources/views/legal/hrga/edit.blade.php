@extends('layouts.master')
@section('title', 'Edit Dokumen HRGA')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('dokumen_hrga_edit') }}

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Dokumen HRGA</h4>
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i
                            class="fa fa-redo"></i>
                    </a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse">
                        <i class="fa fa-minus"></i>
                    </a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <form action="{{ route('dokumen-hrga.update', $dokumenHrga->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="nama">Nama</label>
                                <input class="form-control @error('nama') is-invalid @enderror" type="text" id="nama"
                                    name="nama" placeholder="Nama"
                                    value="{{ old('nama') ? old('nama') : $dokumenHrga->nama }}" required autofocus />
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-2 my-3 text-center">
                                    <a href="/legal/dokumen-hrga/download/{{ $dokumenHrga->file }}" target="_blank">
                                        <img src="/img/document.png" alt="File HRGA" width="50">
                                    </a>
                                </div>

                                <div class="col-md-10">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="file">File
                                            <small>(biarkan kosong jika tidak ingin diganti)</small>
                                        </label>
                                        <input class="form-control @error('file') is-invalid @enderror" type="file"
                                            id="file" name="file" placeholder="file" />
                                        <small>File: png, jpg, jpeg, pdf, doc, docx. max: 2MB</small>
                                        @error('file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="keterangan">Keterangan</label>
                                <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan"
                                    name="keterangan" placeholder="Keterangan" rows="5"
                                    required>{{ old('keterangan') ? old('keterangan') : $dokumenHrga->keterangan }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="reset" class="btn btn-secondary me-1">Reset</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
