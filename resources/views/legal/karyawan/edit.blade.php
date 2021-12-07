@extends('layouts.master')
@section('title', 'Edit Karyawan')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('karyawan_edit') }}

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Karyawan</h4>
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
                @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST" enctype="multipart/form-data"
                    novalidate>
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="nama">Nama</label>
                                <input class="form-control @error('nama') is-invalid @enderror" type="text" id="nama"
                                    name="nama" placeholder="Nama"
                                    value="{{ old('nama') ? old('nama') : $karyawan->nama }}" required autofocus />
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email" id="email"
                                    name="email" placeholder="Email"
                                    value="{{ old('email') ? old('email') : $karyawan->email }}" required autofocus />
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="nik">NIK</label>
                                <input class="form-control @error('nik') is-invalid @enderror" type="number" id="nik"
                                    name="nik" placeholder="NIK" value="{{ old('nik') ? old('nik') : $karyawan->nik }}"
                                    required autofocus />
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="nik">Tanggal Masuk</label>
                                <input class="form-control @error('tgl_masuk') is-invalid @enderror" type="date"
                                    id="tgl_masuk" name="tgl_masuk" placeholder="tgl_masuk"
                                    value="{{ old('tgl_masuk') ? old('tgl_masuk') : date('Y-m-d', strtotime($karyawan->tgl_masuk)) }}"
                                    required autofocus />
                                @error('tgl_masuk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="gaji_pokok">Gaji Pokok</label>
                                <input class="form-control @error('gaji_pokok') is-invalid @enderror" type="number"
                                    id="gaji_pokok" name="gaji_pokok" placeholder="Gaji Pokok"
                                    value="{{ old('gaji_pokok') ? old('gaji_pokok') : $karyawan->gaji_pokok }}" required
                                    autofocus />
                                @error('gaji_pokok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="alamat">Alamat</label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat"
                                    name="alamat" placeholder="Alamat" rows="9" required
                                    autofocus>{{ old('alamat') ? old('alamat') : $karyawan->alamat }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                                <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin"
                                    name="jenis_kelamin" required>
                                    <option value="" disabled selected>-- Pilih --</option>
                                    @foreach ($jenisKelamin as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $karyawan->jenis_kelamin ? 'selected' : '' }}>
                                            {{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="form-group mb-3">
                                <label class="form-label" for="divisi">Divisi</label>
                                <select class="form-select @error('divisi') is-invalid @enderror" id="divisi" name="divisi"
                                    required>
                                    <option value="" disabled selected>-- Pilih --</option>
                                    @foreach ($divisi as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $karyawan->divisi_id ? 'selected' : '' }}>
                                            {{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('divisi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="jabatan">Jabatan</label>
                                <select class="form-select @error('jabatan') is-invalid @enderror" id="jabatan"
                                    name="jabatan" required>
                                    <option value="" disabled selected>-- Pilih --</option>
                                    @foreach ($jabatan as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $karyawan->jabatan_id ? 'selected' : '' }}>
                                            {{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('jabatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="lokasi">Lokasi</label>
                                <select class="form-select @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi"
                                    required>
                                    <option value="" disabled selected>-- Pilih --</option>
                                    @foreach ($lokasi as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $karyawan->lokasi_id ? 'selected' : '' }}>
                                            {{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="status_karyawan">Status Karyawan</label>
                                <select class="form-select @error('status_karyawan') is-invalid @enderror"
                                    id="status_karyawan" name="status_karyawan" required>
                                    <option value="" disabled selected>-- Pilih --</option>
                                    @foreach ($statusKaryawan as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $karyawan->status_karyawan_id ? 'selected' : '' }}>
                                            {{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('status_karyawan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="status_kawin">Status kawin</label>
                                <select class="form-select @error('status_kawin') is-invalid @enderror" id="status_kawin"
                                    name="status_kawin" required>
                                    <option value="" disabled selected>-- Pilih --</option>
                                    @foreach ($statusKawin as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $karyawan->status_kawin ? 'selected' : '' }}>
                                            {{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('status_kawin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-2">
                                <div class="row">
                                    <div class="col-md-3">
                                        @if ($karyawan->foto != null)
                                            <img src="{{ asset('storage/img/karyawan/' . $karyawan->foto) }}"
                                                alt="Foto Karyawan" class="img-fluid rounded"
                                                style="width: 150px; height: 120px; object-fit: cover; border-radius: 3px;">
                                        @else
                                            <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($karyawan->email))) }}&s=150"
                                                alt="Foto Karyawan" class="img-fluid rounded"
                                                style="width: 150px; height: 120px; object-fit: cover; border-radius: 3px;">
                                        @endif
                                    </div>

                                    <div class="col-md-9">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="status_keaktifan">Status Keaktifan</label>
                                            <select class="form-select @error('status_keaktifan') is-invalid @enderror"
                                                id="status_keaktifan" name="status_keaktifan" required>
                                                <option value="" disabled selected>-- Pilih --</option>
                                                @foreach ($statusKeaktifan as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $item->id == $karyawan->status_keaktifan ? 'selected' : '' }}>
                                                        {{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                            @error('status_keaktifan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="form-label" for="foto">Foto <small>(biarkan kosong jika tidak
                                                    ingin diganti)</small></label>
                                            <input class="form-control @error('foto') is-invalid @enderror" type="file"
                                                id="foto" name="foto" placeholder="foto" required autofocus />
                                            @error('foto')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
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
