@extends('layouts.master')
@section('title', 'Create Document')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('document_create') }}

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Document</h4>
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
                <form action="{{ route('document.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="nama">Nama</label>
                                <input class="form-control @error('nama') is-invalid @enderror" type="text" id="nama"
                                    name="nama" placeholder="Nama" value="{{ old('nama') }}" required />
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="tanggal_buat">Tanggal Buat</label>
                                <input class="form-control @error('tanggal_buat') is-invalid @enderror" type="date"
                                    id="tanggal_buat" name="tanggal_buat" value="{{ old('tanggal_buat') }}" required />
                                @error('tanggal_buat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="tanggal_expired">Tanggal Expired</label>
                                <input class="form-control @error('tanggal_expired') is-invalid @enderror" type="date"
                                    id="tanggal_expired" name="tanggal_expired" value="{{ old('tanggal_expired') }}"
                                    required />
                                @error('tanggal_expired')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="tempat_buat">Tempat Pembuatan</label>
                                <input class="form-control @error('tempat_buat') is-invalid @enderror" type="text"
                                    id="tempat_buat" name="tempat_buat" placeholder="Tempat Pembuatan"
                                    value="{{ old('tempat_buat') }}" required />
                                @error('tempat_buat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="category_document">Category Document</label>
                                <select class="form-select @error('category_document') is-invalid @enderror"
                                    id="category_document" name="category_document" required>
                                    <option value="" disabled selected>-- Pilih --</option>
                                    @forelse ($categoryDocument as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @empty
                                        <option value="" disabled>Data tidak ditemukan</option>
                                    @endforelse
                                </select>
                                @error('category_document')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="file">File/Dokumen</label>
                                <input class="form-control @error('file') is-invalid @enderror" type="file" id="file"
                                    name="file" required />
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="reset" class="btn btn-secondary me-1">Reset</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
