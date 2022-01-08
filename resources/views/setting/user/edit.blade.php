@extends('layouts.master')
@section('title', 'Edit User')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('user_edit') }}

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
                <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label" for="name">Nama</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text" id="name"
                                    name="name" placeholder="Name" value="{{ old('name') ? old('name') : $user->name }}"
                                    required autofocus />
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email" id="email"
                                    name="email" placeholder="Email"
                                    value="{{ old('email') ? old('email') : $user->email }}" required />
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label" for="role">Role</label>
                                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role"
                                    required>
                                    <option value="" disabled selected {{ $user->id == 1 ? 'readonly' : '' }}>-- Pilih
                                        Role --</option>
                                    @forelse ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ $user->roles[0]->id == $role->id ? 'selected' : '' }}>{{ $role->name }}
                                        </option>
                                    @empty
                                        <option value="" disabled>Data tidak ditemukan</option>
                                    @endforelse
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="password">Password</label>
                                <input class="form-control @error('password') is-invalid @enderror" type="password"
                                    id="password" name="password" placeholder="Password" />
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="password_confirmation">Password Confirmation</label>
                                <input class="form-control @error('password_confirmation') is-invalid @enderror"
                                    type="password" id="password_confirmation" name="password_confirmation"
                                    placeholder="Password Confirmation" />
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-md-2">
                                    @if ($user->foto != null)
                                        <img src="{{ asset('storage/img/user/' . $user->foto) }}" alt="Foto User"
                                            class="img-fluid rounded"
                                            style="width: 150px; height: 120px; object-fit: cover; border-radius: 3px;">
                                    @else
                                        <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($user->email))) }}&s=150"
                                            alt="Foto User" class="img-fluid rounded"
                                            style="width: 150px; height: 120px; object-fit: cover; border-radius: 3px;">
                                    @endif
                                </div>
                                <div class="col-md-10">
                                    <label class="form-label" for="foto">Foto</label>
                                    <input class="form-control @error('foto') is-invalid @enderror" type="file" id="foto"
                                        name="foto" placeholder="foto" />
                                    @error('foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="reset" class="btn btn-secondary me-1">Reset</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
