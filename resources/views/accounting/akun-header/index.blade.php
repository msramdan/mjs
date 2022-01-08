@extends('layouts.master')
@section('title', 'Account Header')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('header_index') }}

        @can('create account header')
            <div class="d-flex justify-content-end">
                <a href="{{ route('akun-header.create') }}" class="btn btn-primary mb-3">
                    <i class="fas fa-plus me-1"></i>
                    Create
                </a>
            </div>
        @endcan

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">{{ trans('sidebar.sub_menu.akun_header') }}</h4>
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
                                        <th>Kode Akun Header</th>
                                        <th>Akun Header</th>
                                        <th>Akun Grup</th>
                                        @canany(['edit account header', 'delete account header'])
                                            <th>Action</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($akunHeader as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->kode }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->akun_group->nama }}</td>
                                            @canany(['edit account header', 'delete account header'])
                                                <td>
                                                    @can('edit account header')
                                                        <a href="{{ route('akun-header.edit', $item->id) }}"
                                                            class="btn btn-primary btn-xs mb-1">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endcan

                                                    @can('delete account header')
                                                        <form action="{{ route('akun-header.destroy', $item->id) }}" method="POST"
                                                            class="d-inline"
                                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                                            @method('DELETE')
                                                            @csrf

                                                            <button type="submit" class="btn btn-danger btn-xs mb-1">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </td>
                                            @endcanany
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
