@extends('layouts.master')
@section('title', 'BAC Terima')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('bac_terima_index') }}

        @can('create bac terima')
            <div class="d-flex justify-content-end">
                <a href="{{ route('bac-terima.create') }}" class="btn btn-primary mb-3">
                    <i class="fas fa-plus me-1"></i>
                    Create
                </a>
            </div>
        @endcan

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">BAC Terima</h4>
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
                                        <th>Purchase</th>
                                        <th>Kode</th>
                                        <th>User</th>
                                        <th>Tangal</th>
                                        <th>Keterangan</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        @canany(['edit bac terima', 'delete bac terima'])
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
            '{{ auth()->user()->can('edit bac terima') ||
            auth()->user()->can('delete bac terima')
                ? 'yes yes yes'
                : '' }}'

        const columns = [{
                data: 'purchase',
                name: 'purchase'
            }, {
                data: 'kode',
                name: 'kode'
            },
            {
                data: 'user',
                name: 'user'
            },
            {
                data: 'tanggal',
                name: 'tanggal'
            },
            {
                data: 'keterangan',
                name: 'keterangan'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'updated_at',
                name: 'updated_at'
            }
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
            ajax: "{{ route('bac-terima.index') }}",
            columns: columns
        });
    </script>
@endpush
