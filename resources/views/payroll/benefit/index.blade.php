@extends('layouts.master')
@section('title', 'Data Benefit')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('benefit_index') }}

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">{{ trans('sidebar.sub_menu.benefit') }}</h4>
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
                                        <th>Nama Karyawan</th>
                                        <th>NIK</th>
                                        @canany(['edit benefit', 'delete benefit'])
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
            '{{ auth()->user()->can('edit benefit') ||
            auth()->user()->can('delete benefit')
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
                data: 'nik',
                name: 'nik'
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
            ajax: "{{ route('benefit.index') }}",
            columns: columns
        });
    </script>
@endpush
