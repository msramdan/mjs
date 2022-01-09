@extends('layouts.master')
@section('title', 'Setting Applikasi')

@section('content')
    <div id="content" class="app-content">
        <div class="col-xl-12 ui-sortable">
            <div class="panel panel-inverse" data-sortable-id="form-stuff-1" style="" data-init="true">

                <div class="panel-heading ui-sortable-handle">
                    <h4 class="panel-title">SETTING APP</h4>

                    <div class="panel-heading-btn">
                        {{-- <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"
                            data-bs-original-title="" title="" data-tooltip-init="true">
                            <i class="fa fa-expand"></i>
                        </a> --}}

                        <a href="javascript:;" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload">
                            <i class="fa fa-redo"></i>
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
                    <form action="{{ route('setting_app.update', $data->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <thead>
                            <table class="table  table-bordered table-hover table-td-valign-middle">
                                <tr>
                                    <td>Nama Aplikasi</td>
                                    <td>
                                        <input type="text" class="form-control @error('nama_aplikasi') is-invalid @enderror"
                                            name="nama_aplikasi" id="nama_aplikasi" placeholder="Nama Aplikasi"
                                            value="{{ old('nama_aplikasi') ? old('nama_aplikasi') : $data->nama_aplikasi }}" />
                                        @error('nama_aplikasi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nama Perusahaan</td>
                                    <td><input type="text"
                                            class="form-control @error('nama_perusahaan') is-invalid @enderror"
                                            name="nama_perusahaan" id="nama_perusahaan" placeholder="Nama Perusahaan"
                                            value="{{ old('nama_perusahaan') ? old('nama_perusahaan') : $data->nama_perusahaan }}" />
                                        @error('nama_perusahaan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>Alamat Perusahaan</td>
                                    <td><input type="text"
                                            class="form-control @error('alamat_perusahaan') is-invalid @enderror"
                                            name="alamat_perusahaan" id="alamat_perusahaan" placeholder="Alamat Perusahaan"
                                            value="{{ old('alamat_perusahaan') ? old('alamat_perusahaan') : $data->alamat_perusahaan }}" />
                                        @error('alamat_perusahaan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nama Direktur</td>
                                    <td><input type="text" class="form-control @error('nama_direktur') is-invalid @enderror"
                                            name="nama_direktur" id="nama_direktur" placeholder="Nama Direktur"
                                            value="{{ old('nama_direktur') ? old('nama_direktur') : $data->nama_direktur }}" />
                                        @error('nama_direktur')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>Logo Perusahaan</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-3">
                                                @if ($data->logo_perusahaan != null)
                                                    <img src="{{ Storage::url('public/logo/') . $data->logo_perusahaan }}"
                                                        alt="Logo Perusahaan" class="img-fluid rounded"
                                                        style="width: 150px;height: 150px;border-radius: 10%;">
                                                @else
                                                    <img src="https://www.zonefresh.co.id/assets/images/product/default.jpg"
                                                        alt="Logo Perusahaan" class="img-fluid rounded"
                                                        style="width: 150px;height: 150px;border-radius: 10%;">
                                                @endif
                                            </div>

                                            <div class="col-md-9">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="logo_perusahaan">Logo Perusahaan
                                                        <small>(biarkan kosong jika tidak ingin diganti)</small></label>
                                                    <input
                                                        class="form-control @error('logo_perusahaan') is-invalid @enderror"
                                                        type="file" id="logo_perusahaan" name="logo_perusahaan"
                                                        placeholder="Logo Perusahaan" autofocus />
                                                    @error('logo_perusahaan')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <button type="submit" class="btn btn-danger"><i
                                                class="fas fa-save"></i>Update</button>
                                        <a class="btn btn-info" onclick="self.history.back()"><i
                                                class="fas fa-undo"></i> Kembali</a>
                                    </td>
                                </tr>
                        </thead>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
