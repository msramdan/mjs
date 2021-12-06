@extends('layouts.master')
@section('title', 'Create User')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('user_create') }}

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">User</h4>
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
                <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label class="form-label" for="name">Nama</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text" id="name"
                                    name="name" placeholder="Name" value="{{ old('name') }}" required autofocus />
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email" id="email"
                                    name="email" placeholder="Email" value="{{ old('email') }}" required />
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="role">Role</label>
                                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role"
                                    required>
                                    <option value="" disabled selected>-- Pilih Role --</option>
                                    @forelse ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @empty
                                        <option value="" disabled>Data tidak ditemukan</option>
                                    @endforelse
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="password">Password</label>
                                <input class="form-control @error('password') is-invalid @enderror" type="password"
                                    id="password" name="password" placeholder="Password" required />
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="password_confirmation">Password Confirmation</label>
                                <input class="form-control @error('password_confirmation') is-invalid @enderror"
                                    type="password" id="password_confirmation" name="password_confirmation"
                                    placeholder="Password Confirmation" required />
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="foto">Foto</label>
                                <input class="form-control @error('foto') is-invalid @enderror" type="file" id="foto"
                                    name="foto" placeholder="foto" />
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="reset" class="btn btn-secondary me-1">Reset</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>

                        <div class="col-md-4">
                            <label class="mb-2">Permissions</label>
                            @foreach ($permissions as $permission)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="checkbox{{ $permission->id }}"
                                        name="permissions[]" value="{{ $permission->name }}" />
                                    <label class="form-check-label"
                                        for="checkbox{{ $permission->id }}">{{ ucwords($permission->name) }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
