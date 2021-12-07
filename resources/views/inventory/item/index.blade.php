@extends('layouts.master')
@section('title', 'Item')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('item_index') }}

        <div class="d-flex justify-content-end">
            <a href="{{ route('item.create') }}" class="btn btn-primary mb-3">
                <i class="fas fa-plus me-1"></i>
                Create
            </a>
        </div>

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
                <div class="card bg-dark border-0 text-white">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped" id="data-table" width="100%">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Category</th>
                                        <th>Unit</th>
                                        <th>Type</th>
                                        <th>Stok</th>
                                        <th>Deskripsi</th>
                                        <th>Akun Beban</th>
                                        <th>Akun Retur Pembelian</th>
                                        <th>Akun Penjualan</th>
                                        <th>Akun Retur Penjualan</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.3/r-2.2.9/datatables.min.css" />
@endpush

@push('js')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.3/r-2.2.9/datatables.min.js"></script>

    <script>
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('item.index') }}",
            columns: [{
                    data: 'kode',
                    name: 'kode'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'category',
                    name: 'category'
                },
                {
                    data: 'unit',
                    name: 'unit'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'stok',
                    name: 'stok'
                },
                {
                    data: 'deskripsi',
                    name: 'deskripsi'
                },
                {
                    data: 'akun_beban',
                    name: 'akun_beban'
                },
                {
                    data: 'akun_retur_pembelian',
                    name: 'akun_retur_pembelian'
                },
                {
                    data: 'akun_penjualan',
                    name: 'akun_penjualan'
                },
                {
                    data: 'akun_retur_penjualan',
                    name: 'akun_retur_penjualan'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
        });
    </script>
@endpush
