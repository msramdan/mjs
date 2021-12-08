@extends('layouts.master')
@section('title', 'Edit Spal')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('spal_edit') }}

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
                <form action="{{ route('spal.update', $spal->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="kode">Kode</label>
                                <input class="form-control @error('kode') is-invalid @enderror" type="text" id="kode"
                                    name="kode" placeholder="Kode" value="{{ old('kode') ? old('kode') : $spal->kode }}"
                                    required autofocus />
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="nama_kapal">Nama Kapal</label>
                                <input class="form-control @error('nama_kapal') is-invalid @enderror" type="text"
                                    id="nama_kapal" name="nama_kapal" placeholder="Nama Kapal"
                                    value="{{ old('nama_kapal') ? old('nama_kapal') : $spal->nama_kapal }}" required />
                                @error('nama_kapal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="nama_muatan">Nama Muatan</label>
                                <input class="form-control @error('nama_muatan') is-invalid @enderror" type="text"
                                    id="nama_muatan" name="nama_muatan" placeholder="Nama Muatan"
                                    value="{{ old('nama_muatan') ? old('nama_muatan') : $spal->nama_muatan }}" required />
                                @error('nama_muatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="jml_muatan">Jumlah Muatan</label>
                                <input class="form-control @error('jml_muatan') is-invalid @enderror" type="number"
                                    id="jml_muatan" name="jml_muatan" placeholder="Jumlah Muatan"
                                    value="{{ old('jml_muatan') ? old('jml_muatan') : $spal->jml_muatan }}" required />
                                @error('jml_muatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="customer">Customer</label>
                                <select class="form-select @error('customer') is-invalid @enderror" id="customer"
                                    name="customer" required>
                                    <option value="" disabled selected>-- Pilih --</option>
                                    @foreach ($customer as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $spal->customer_id == $item->id ? 'selected' : '' }}>{{ $item->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="harga_unit">Harga/Unit</label>
                                <input class="form-control @error('harga_unit') is-invalid @enderror" type="number"
                                    id="harga_unit" name="harga_unit" placeholder="Harga/Unit"
                                    value="{{ old('harga_unit') ? old('harga_unit') : $spal->harga_unit }}" required />
                                @error('harga_unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row form-group">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="pelabuhan_muat">Pelabuhan Muat</label>
                                    <input class="form-control @error('pelabuhan_muat') is-invalid @enderror" type="text"
                                        id="pelabuhan_muat" name="pelabuhan_muat" placeholder="Pelabuhan Muat"
                                        value="{{ old('pelabuhan_muat') ? old('pelabuhan_muat') : $spal->pelabuhan_muat }}"
                                        required />
                                    @error('pelabuhan_muat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="pelabuhan_bongkar">Pelabuhan Bongkar</label>
                                    <input class="form-control @error('pelabuhan_bongkar') is-invalid @enderror" type="text"
                                        id="pelabuhan_bongkar" name="pelabuhan_bongkar" placeholder="Pelabuhan Bongkar"
                                        value="{{ old('pelabuhan_bongkar') ? old('pelabuhan_bongkar') : $spal->pelabuhan_bongkar }}"
                                        required />
                                    @error('pelabuhan_bongkar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2 my-3 text-center">
                                    <a href="/sale/spal/download/{{ $spal->file }}" target="_blank">
                                        <img src="/img/document.png" alt="Gambar File" width="50">
                                    </a>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="file">File/Dokumen <small>(biarkan kosong jika
                                                tidak ingin diupdate)</small></label>
                                        <input class="form-control @error('file') is-invalid @enderror" type="file"
                                            id="file" name="file" />
                                        @error('file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
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
