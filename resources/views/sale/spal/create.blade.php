@extends('layouts.master')
@section('title', 'Create Spal')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('spal_create') }}

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Spal</h4>
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
                <form action="{{ route('spal.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="kode">Kode</label>
                                <input class="form-control @error('kode') is-invalid @enderror" type="text" id="kode"
                                    name="kode" placeholder="Kode" value="{{ old('kode') }}" required autofocus />
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="nama_kapal">Nama Kapal</label>
                                <input class="form-control @error('nama_kapal') is-invalid @enderror" type="text"
                                    id="nama_kapal" name="nama_kapal" placeholder="Nama Kapal"
                                    value="{{ old('nama_kapal') }}" required autofocus />
                                @error('nama_kapal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="nama_muatan">Nama Muatan</label>
                                <input class="form-control @error('nama_muatan') is-invalid @enderror" type="text"
                                    id="nama_muatan" name="nama_muatan" placeholder="Nama Muatan"
                                    value="{{ old('nama_muatan') }}" required autofocus />
                                @error('nama_muatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="jml_muatan">Jumlah Muatan</label>
                                <input class="form-control @error('jml_muatan') is-invalid @enderror" type="number"
                                    id="jml_muatan" name="jml_muatan" placeholder="Jumlah Muatan"
                                    value="{{ old('jml_muatan') }}" required autofocus />
                                @error('jml_muatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <button type="reset" class="btn btn-secondary me-1">Reset</button>
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="customer">Customer</label>
                                <select class="form-select @error('customer') is-invalid @enderror" id="customer"
                                    name="customer" required>
                                    <option value="" disabled selected>-- Pilih --</option>
                                    @foreach ($customer as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('customer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="pelabuhan_muat">Pelabuhan Muat</label>
                                <input class="form-control @error('pelabuhan_muat') is-invalid @enderror" type="text"
                                    id="pelabuhan_muat" name="pelabuhan_muat" placeholder="Pelabuhan Muat"
                                    value="{{ old('pelabuhan_muat') }}" required autofocus />
                                @error('pelabuhan_muat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="pelabuhan_bongkar">Pelabuhan Bongkar</label>
                                <input class="form-control @error('pelabuhan_bongkar') is-invalid @enderror" type="text"
                                    id="pelabuhan_bongkar" name="pelabuhan_bongkar" placeholder="Pelabuhan Bongkar"
                                    value="{{ old('pelabuhan_bongkar') }}" required autofocus />
                                @error('pelabuhan_bongkar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="harga_unit">Harga/Unit</label>
                                <input class="form-control @error('harga_unit') is-invalid @enderror" type="number"
                                    id="harga_unit" name="harga_unit" placeholder="Harga/Unit"
                                    value="{{ old('harga_unit') }}" required autofocus />
                                @error('harga_unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="file">File</label>
                                <input class="form-control @error('file') is-invalid @enderror" type="file" id="file"
                                    name="file" value="{{ old('file') }}" required autofocus />
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
