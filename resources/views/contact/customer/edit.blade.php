@extends('layouts.master')
@section('title', 'Edit Customer')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('customer_edit') }}

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Customer</h4>
                <div class="panel-heading-btn">
                    {{-- <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand">
                        <i class="fa fa-expand"></i>
                    </a> --}}
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
                <form action="{{ route('customer.update', $customer->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="kode">Kode</label>
                                <input class="form-control @error('kode') is-invalid @enderror" type="text" id="kode"
                                    name="kode" placeholder="Kode"
                                    value="{{ old('kode') ? old('kode') : $customer->kode }}" required autofocus />
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="nama">Nama</label>
                                <input class="form-control @error('nama') is-invalid @enderror" type="text" id="nama"
                                    name="nama" placeholder="Nama"
                                    value="{{ old('nama') ? old('nama') : $customer->nama }}" required />
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="alamat">Alamat</label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat"
                                    name="alamat" placeholder="Alamat" rows="7"
                                    required>{{ old('alamat') ? old('alamat') : $customer->alamat }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="catatan">Catatan</label>
                                <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan"
                                    name="catatan" placeholder="Catatan" rows="7"
                                    required>{{ old('catatan') ? old('catatan') : $customer->catatan }}</textarea>
                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email" id="email"
                                    name="email" placeholder="Email"
                                    value="{{ old('email') ? old('email') : $customer->email }}" required />
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="kota">Kota</label>
                                <input class="form-control @error('kota') is-invalid @enderror" type="text" id="kota"
                                    name="kota" placeholder="Kota"
                                    value="{{ old('kota') ? old('kota') : $customer->kota }}" required />
                                @error('kota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="provinsi">Provinsi</label>
                                <input class="form-control @error('provinsi') is-invalid @enderror" type="text"
                                    id="provinsi" name="provinsi" placeholder="Provinsi"
                                    value="{{ old('provinsi') ? old('provinsi') : $customer->provinsi }}" required />
                                @error('provinsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="telp">Telepon</label>
                                <input class="form-control @error('telp') is-invalid @enderror" type="telp" id="telp"
                                    name="telp" placeholder="Telepon"
                                    value="{{ old('telp') ? old('telp') : $customer->telp }}" required />
                                @error('telp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="personal_kontak">Personal Kontak</label>
                                <input class="form-control @error('personal_kontak') is-invalid @enderror" type="text"
                                    id="personal_kontak" name="personal_kontak" placeholder="Personal Kontak"
                                    value="{{ old('personal_kontak') ? old('personal_kontak') : $customer->personal_kontak }}" />
                                @error('personal_kontak')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="website">Website</label>
                                <input class="form-control @error('website') is-invalid @enderror" type="text" id="website"
                                    name="website" placeholder="Website"
                                    value="{{ old('website') ? old('website') : $customer->website }}" />
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="kode_pos">Kode Pos</label>
                                <input class="form-control @error('kode_pos') is-invalid @enderror" type="text"
                                    id="kode_pos" name="kode_pos" placeholder="Kode Pos"
                                    value=" {{ old('kode_pos') ? old('kode_pos') : $customer->kode_pos }}" />
                                @error('kode')
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
