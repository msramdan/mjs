@extends('layouts.master')
@section('title', 'Create Role')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('role_create') }}

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Role</h4>
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
                <form action="{{ route('role.store') }}" method="POST">
                    @csrf
                    @method('POST')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="name">Nama</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text" id="name"
                                    name="name" placeholder="Name" value="{{ old('name') }}" required autofocus />
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <h6>Permissions</h6>
                    <div class="row">
                        @foreach (config('permission.list_permissions') as $permission)
                            <div class="col-md-3 mb-4">
                                <div class="card">
                                    <div class="card-header bg-dark">{{ ucfirst($permission['group']) }}</div>
                                    <div class="card-body">
                                        @foreach ($permission['lists'] as $list)
                                            <div class="form-check mb-1">
                                                <input class="form-check-input" type="checkbox"
                                                    id="{{ Str::slug($list) }}" name="permissions[]"
                                                    value="{{ $list }}" />
                                                <label class="form-check-label"
                                                    for="{{ Str::slug($list) }}">{{ ucwords($list) }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="reset" class="btn btn-secondary me-1">Reset</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
