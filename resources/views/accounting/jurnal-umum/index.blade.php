@extends('layouts.master')
@section('title', trans('sidebar.sub_menu.jurnal_umum'))

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('jurnal_umum_index') }}

        {{-- @can('create jurnal umum') --}}
        <div class="d-flex justify-content-end">
            <a href="{{ route('jurnal-umum.create') }}" class="btn btn-primary mb-3">
                <i class="fas fa-plus me-1"></i>
                Create
            </a>
        </div>
        {{-- @endcan --}}

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">{{ trans('sidebar.sub_menu.jurnal_umum') }}</h4>
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
                <div class="card bg-dark border-0 text-white">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped" id="data-table" width="100%">
                                <thead>
                                    <tr>
                                        <th>Tangal</th>
                                        <th>No. Bukti</th>
                                        <th>No. Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Description</th>
                                        <th>Debet</th>
                                        <th>Kredit</th>
                                        <th>Ref No.</th>
                                        {{-- @canany(['edit unit', 'delete unit']) --}}
                                        <th>Action</th>
                                        {{-- @endcanany --}}
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

    {{-- <script>
        const action =
            '{{ auth()->user()->can('edit unit') ||
            auth()->user()->can('delete unit')
                ? 'yes yes yes'
                : '' }}'

        let columns = [{
                data: 'nama',
                name: 'nama'
            },
            {
                data: 'status',
                name: 'status'
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
            ajax: "{{ route('unit.index') }}",
            columns: columns
        });
    </script> --}}
@endpush
