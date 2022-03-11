@extends('layouts.master')
@section('title', 'Time Sheet')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('time_sheet_index') }}

        @can('create time sheet')
            <div class="d-flex justify-content-end">
                <a href="{{ route('time_sheet.create') }}" class="btn btn-primary mb-3">
                    <i class="fas fa-plus me-1"></i>
                    Create
                </a>
            </div>
        @endcan

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Time Sheet</h4>
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
                                        <th>#</th>
                                        <th>Kode</th>
                                        <th>time_sheet</th>
                                        <th>jumlah Waktu</th>
                                        <th>Created At</th>
                                        {{-- @canany(['edit time_sheet', 'delete time_sheet']) --}}
                                        <th>Action</th>
                                        {{-- @endcanany --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->kode_time_sheet }}</td>
                                            <td>{{ $item->kode }}</td>
                                            <td>{{ $item->qty }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>
                                                @can('edit time sheet')
                                                    <a href="{{ route('time_sheet.edit', $item->id) }}"
                                                        class="btn btn-primary btn-xs mb-1">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan

                                                @can('delete time sheet')
                                                    <form action="{{ route('time_sheet.destroy', $item->id) }}" method="post"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                        @csrf
                                                        @method('delete')

                                                        <button class="btn btn-danger btn-xs mb-1">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
