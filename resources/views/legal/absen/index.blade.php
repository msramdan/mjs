@extends('layouts.master')
@section('title', 'Absen')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('absen_index') }}

        @can('create item')
            <div class="d-flex justify-content-end">
                <a href="{{ route('item.create') }}" class="btn btn-primary mb-3">
                    <i class="fas fa-plus me-1"></i>
                    Create
                </a>
            </div>
        @endcan

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
                                        <th>No</th>
                                        <th>User</th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Status Absen</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Pulang</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($absen as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->tanggal }}</td>
                                            <td>{{ $row->keterangan }}</td>
                                            @if ($row->status_masuk == 'Terlambat')
                                                <td><span class="badge bg-danger">{{ $row->status_masuk }}</span></td>
                                            @else
                                                <td><span class="badge bg-success">{{ $row->status_masuk }}</span></td>
                                            @endif
                                            <td>{{ $row->jam_masuk }}</td>
                                            <td>{{ $row->jam_pulang }}</td>
                                            <td>
                                                <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                    action="{{ route('absen.destroy', $row->id) }}" method="POST">
                                                    @can('edit kehadiran')
                                                        <a href="{{ route('absen.edit', $row->id) }}"
                                                            class="btn btn-primary btn-xs mb-1">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                    @csrf
                                                    @method('DELETE')
                                                    @can('delete kehadiran')
                                                        <button type="submit" class="btn btn-danger btn-xs mb-1">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    @endcan
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
