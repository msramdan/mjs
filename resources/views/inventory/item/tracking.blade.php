@extends('layouts.master')
@section('title', 'Item Tracking')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('item_create') }}

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Item Tracking</h4>
                <div class="panel-heading-btn">
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
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label" for="kode">Kode</label>
                            <input class="form-control" type="text" id="kode" name="kode" placeholder="Kode"
                                value="{{ $item->kode }}" disabled autofocus />
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label" for="nama">Nama</label>
                            <input class="form-control" type="text" id="nama" name="nama" placeholder="Nama"
                                value="{{ $item->nama }}" disabled />
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label" for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi"
                                rows="5" disabled>{{ $item->deskripsi }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label" for="unit">Unit</label>
                            <input class="form-control" type="text" id="unit" name="unit" placeholder="unit"
                                value="{{ $item->unit->nama }}" disabled />
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="stok">Stok</label>
                                    <input class="form-control" type="text" id="stok" name="stok" placeholder="stok"
                                        value="{{ $item->stok }}" disabled />
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="category">Category</label>
                                    <input class="form-control" type="text" id="category" name="category"
                                        placeholder="category" value="{{ $item->category->nama }}" disabled />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ asset('storage/img/item/' . $item->foto) }}" alt="Foto item"
                                    class="img-fluid rounded"
                                    style="width: 150px; height: 120px; object-fit: cover; border-radius: 3px;">
                            </div>

                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="akun_coa">Akun COA</label>
                                    <input class="form-control" type="text" id="akun_coa" name="akun_coa"
                                        placeholder="akun_coa" value="{{ $item->akun_coa->nama }}" disabled />
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label" for="type">Type</label>
                                    <input class="form-control" type="text" id="type" name="type" placeholder="type"
                                        value="{{ $item->type }}" disabled />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h5>BAC Terima</h5>
                <div class="table-responsive mb-3">
                    <table class="table table-hover table-striped table-bordered table-sm" id="data-table" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Tanggal BAC</th>
                                <th>Qty</th>
                                <th>Qty Validasi</th>
                                <th>Status</th>
                                <th>Tanggal Validasi</th>
                                <th>Divalidasi Oleh</th>
                            </tr>
                        </thead>

                        @forelse ($item->detail_bac_terima as $itm)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $itm->bac_terima->kode }}</td>
                                <td>{{ $itm->bac_terima->tanggal->format('d/m/Y') }}</td>
                                <td>{{ $itm->qty }}</td>
                                <td>{{ $itm->qty_validasi ? $itm->qty_validasi : '-' }}</td>
                                <td>{{ $itm->bac_terima->status }}</td>
                                <td>{{ $itm->bac_terima->received ? $itm->bac_terima->received->tanggal_validasi->format('d/m/Y') : '-' }}
                                </td>
                                <td>{{ $itm->bac_terima->received ? $itm->bac_terima->received->divalidasi_oleh->name : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </table>
                </div>

                <h5>BAC Pakai</h5>
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered table-sm" id="data-table" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Tanggal BAC</th>
                                <th>Qty</th>
                                <th>Qty Validasi</th>
                                <th>Status</th>
                                <th>Tanggal Validasi</th>
                                <th>Divalidasi Oleh</th>
                            </tr>
                        </thead>

                        @forelse ($item->detail_bac_pakai as $itm)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $itm->bac_pakai->kode }}</td>
                                <td>{{ $itm->bac_pakai->tanggal->format('d/m/Y') }}</td>
                                <td>{{ $itm->qty }}</td>
                                <td>{{ $itm->qty_validasi ? $itm->qty_validasi : '-' }}</td>
                                <td>{{ $itm->bac_pakai->status }}</td>
                                <td>{{ $itm->bac_pakai->aso ? $itm->bac_pakai->aso->tanggal_validasi->format('d/m/Y') : '-' }}
                                </td>
                                <td>{{ $itm->bac_pakai->aso ? $itm->bac_pakai->aso->divalidasi_oleh->name : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
