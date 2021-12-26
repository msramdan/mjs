@extends('layouts.master')
@section('title', 'Detail Dokumen HRGA')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('dokumen_hrga_show') }}

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
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label" for="nama">Nama</label>
                            <input class="form-control" type="text" id="nama" name="nama" placeholder="Nama"
                                value="{{ $dokumenHrga->nama }}" disabled />
                        </div>

                        <div class="row">
                            <div class="col-md-2 my-3 text-center">
                                <a href="/legal/dokumen-hrga/download/{{ $dokumenHrga->file }}" target="_blank">
                                    <img src="/img/document.png" alt="File HRGA" width="50">
                                </a>
                            </div>

                            <div class="col-md-10">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="file">File</label>
                                    <input class="form-control" type="text" id="file" name="file" placeholder="File"
                                        value="{{ $dokumenHrga->file }}" disabled />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label" for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan"
                                rows="5" disabled>{{ $dokumenHrga->keterangan }}</textarea>
                        </div>
                    </div>
                </div>

                <a href="{{ route('dokumen-hrga.index') }}" class="btn btn-secondary me-1">Back</a>
            </div>
        </div>
    </div>
@endsection
