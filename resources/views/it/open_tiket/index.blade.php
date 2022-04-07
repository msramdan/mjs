@extends('layouts.master')
@section('title', 'Item')

@section('content')
    <div id="content" class="app-content">
        {{ Breadcrumbs::render('open_tiket_index') }}
        @can('create open tiket')
            <div class="d-flex justify-content-end">
                <a href="{{ route('open_tiket.create') }}" class="btn btn-primary mb-3">
                    <i class="fas fa-plus me-1"></i>
                    Create
                </a>
            </div>
        @endcan
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Open Tiket Helpdesk</h4>
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
                                        <th>Nama User</th>
                                        <th>Judul</th>
                                        <th>Pesan</th>
                                        <th>File Attachment</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($open_tiket as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->judul }}</td>
                                            <td>{{ $row->pesan }}</td>

                                            <td> <a href="{{ route('download-photo', $row->id) }}"> <i class="fa fa-download" aria-hidden="true"></i></a></td>
                                            @if ($row->status == 'Open')
                                                <td><span class="badge bg-secondary">{{ $row->status }}</span></td>
                                            @elseif ($row->status == 'On Progress')
                                                <td><span class="badge bg-yellow">{{ $row->status }}</span></td>
                                            @else
                                                <td><span class="badge bg-success">{{ $row->status }}</span></td>
                                            @endif
                                            <td>
                                                <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                    action="{{ route('open_tiket.destroy', $row->id) }}" method="POST">
                                                    @can('edit open tiket')
                                                        <a href="{{ route('open_tiket.edit', $row->id) }}"
                                                            class="btn btn-primary btn-xs mb-1">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                    @csrf
                                                    @method('DELETE')
                                                    @can('delete open tiket')
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
