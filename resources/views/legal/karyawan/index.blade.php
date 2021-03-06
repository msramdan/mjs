@extends('layouts.master')
@section('title', 'Karyawan')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('karyawan_index') }}

        @can('create karyawan')
            <div class="d-flex justify-content-end">
                <a href="{{ route('karyawan.create') }}" class="btn btn-primary mb-3">
                    <i class="fas fa-plus me-1"></i>
                    Create
                </a>
            </div>
        @endcan

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
                <div class="card bg-dark border-0 text-white">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped" id="data-table" width="100%">
                                <thead>
                                    <tr>
                                        <th>Foto</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>NIK</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Divisi</th>
                                        <th>Jabatan</th>
                                        <th>Status Karyawan</th>
                                        <th>Status Kawin</th>
                                        <th>Status Keaktifan</th>
                                        <th>Alamat</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        @canany(['edit karyawan', 'delete karyawan'])
                                            <th>Action</th>
                                        @endcanany
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
        const action =
            '{{ auth()->user()->can('edit karyawan') ||
            auth()->user()->can('delete karyawan')
                ? 'yes yes yes'
                : '' }}'

        let columns = [{
                data: 'foto',
                name: 'foto',
                orderable: false,
                searchable: false,
                render: function(data, type, full, meta) {
                    return `<img src="${data}" alt="Foto Karyawan" class="rounded h-30px"> `;
                }
            },
            {
                data: 'nama',
                name: 'nama'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'nik',
                name: 'nik'
            },
            {
                data: 'jenis_kelamin',
                name: 'jenis_kelamin'
            },
            {
                data: 'tgl_masuk',
                name: 'tgl_masuk'
            },
            {
                data: 'divisi',
                name: 'divisi'
            },
            {
                data: 'jabatan',
                name: 'jabatan'
            },
            {
                data: 'status_karyawan',
                name: 'status_karyawan'
            },
            {
                data: 'status_kawin',
                name: 'status_kawin'
            },
            {
                data: 'status_keaktifan',
                name: 'status_keaktifan'
            },
            {
                data: 'alamat',
                name: 'alamat'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'updated_at',
                name: 'updated_at'
            },
        ]

        if (action) {
            columns.push({
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            })
        }

        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('karyawan.index') }}",
            columns: columns
        });
    </script>
@endpush
