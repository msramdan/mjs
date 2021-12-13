@extends('layouts.master')
@section('title', 'Edit Item')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('unit_edit') }}

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Item</h4>
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
                <form action="{{ route('item.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="kode">Kode</label>
                                <input class="form-control @error('kode') is-invalid @enderror" type="text" id="kode"
                                    name="kode" placeholder="Kode" value="{{ old('kode') ? old('kode') : $item->kode }}"
                                    required autofocus />
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="nama">Nama</label>
                                <input class="form-control @error('nama') is-invalid @enderror" type="text" id="nama"
                                    name="nama" placeholder="Nama" value="{{ old('nama') ? old('nama') : $item->nama }}"
                                    required />
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="deskripsi">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi"
                                    name="deskripsi" placeholder="Deskripsi" rows="5"
                                    required>{{ old('deskripsi') ? old('deskripsi') : $item->deskripsi }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <label class="mb-2">Type</label>
                            <br>
                            <div class="form-check form-check-inline mb-3">
                                <input class="form-check-input" type="radio" name="type" id="consumable" value="Consumable"
                                    {{ $item->type == 'Consumable' ? 'checked' : '' }} />
                                <label class="form-check-label" for="consumable">Consumable</label>
                            </div>

                            <div class="form-check form-check-inline mb-3">
                                <input class="form-check-input" type="radio" name="type" id="services" value="Services"
                                    {{ $item->type == 'Services' ? 'checked' : '' }} />
                                <label class="form-check-label" for="services">Services</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="category">Category</label>
                                <select class="form-select @error('category') is-invalid @enderror" id="category"
                                    name="category" required>
                                    <option value="" disabled selected>-- Pilih --</option>
                                    @foreach ($category as $ctg)
                                        <option value="{{ $ctg->id }}"
                                            {{ $item->category_id == $ctg->id ? 'selected' : '' }}>{{ $ctg->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="unit">Unit</label>
                                <select class="form-select @error('unit') is-invalid @enderror" id="unit" name="unit"
                                    required>
                                    <option value="" disabled selected>-- Pilih --</option>
                                    @foreach ($unit as $ut)
                                        <option value="{{ $ut->id }}"
                                            {{ $item->unit_id == $ut->id ? 'selected' : '' }}>{{ $ut->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="akun_beban">Akun Beban</label>
                                <input class="form-control @error('akun_beban') is-invalid @enderror" type="text"
                                    id="akun_beban" name="akun_beban" placeholder="Akun Beban"
                                    value="{{ old('akun_beban') ? old('akun_beban') : $item->akun_beban }}" required />
                                @error('akun_beban')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="akun_retur_pembelian">Akun Retur Pembelian</label>
                                <input class="form-control @error('akun_retur_pembelian') is-invalid @enderror" type="text"
                                    id="akun_retur_pembelian" name="akun_retur_pembelian" placeholder="Akun Retur Pembelian"
                                    value="{{ old('akun_retur_pembelian') ? old('akun_retur_pembelian') : $item->akun_retur_pembelian }}"
                                    required />
                                @error('akun_retur_pembelian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="akun_penjualan">Akun Penjualan</label>
                                <input class="form-control @error('akun_penjualan') is-invalid @enderror" type="text"
                                    id="akun_penjualan" name="akun_penjualan" placeholder="Akun Penjualan"
                                    value="{{ old('akun_penjualan') ? old('akun_penjualan') : $item->akun_penjualan }}"
                                    required />
                                @error('akun_penjualan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="akun_retur_penjualan">Akun Retur Penjualan</label>
                                <input class="form-control @error('akun_retur_penjualan') is-invalid @enderror" type="text"
                                    id="akun_retur_penjualan" name="akun_retur_penjualan" placeholder="Akun Retur Penjualan"
                                    value="{{ old('akun_retur_penjualan') ? old('akun_retur_penjualan') : $item->akun_retur_penjualan }}"
                                    required />
                                @error('akun_retur_penjualan')
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
