@extends('layouts.master')
@section('title', 'Profile')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('profile_index') }}

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Profile</h4>
                <div class="panel-heading-btn">
                    {{-- <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i
                            class="fa fa-expand"></i></a> --}}
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i
                            class="fa fa-redo"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i
                            class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i
                            class="fa fa-times"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <form method="POST" action="{{ route('profile.update', auth()->id()) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-3">
                            <h4>Profile</h4>
                        </div>
                        <div class="col-md-9">
                            <div class="card bg-dark border-0 text-white">
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label for="email">E-mail Address</label>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror" id="email"
                                            placeholder="E-mail Address" value="{{ auth()->user()->email }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror" id="name"
                                            placeholder="Name" value="{{ auth()->user()->name }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            @if (auth()->user()->foto != null)
                                                <img src="{{ asset('storage/img/user/' . auth()->user()->foto) }}"
                                                    alt="Foto User" class="img-fluid rounded"
                                                    style="width: 150px; height: 120px; object-fit: cover; border-radius: 3px;">
                                            @else
                                                <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim(auth()->user()->email))) }}&s=1000"
                                                    alt="Foto User" class="img-fluid rounded"
                                                    style="width: 150px; height: 120px; object-fit: cover; border-radius: 3px;">
                                            @endif
                                        </div>

                                        <div class="col-md-9">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="foto">Foto <small>(biarkan kosong jika
                                                        tidak
                                                        ingin diganti)</small></label>
                                                <input class="form-control @error('foto') is-invalid @enderror" type="file"
                                                    id="foto" name="foto" placeholder="foto" autofocus />
                                                @error('foto')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <hr class="my-4">
                        </div>

                        <div class="col-md-3">
                            <h4>Password</h4>
                        </div>
                        <div class="col-md-9">
                            <div class="card bg-dark border-0 text-white">
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label for="current_password">Current Password</label>
                                        <input type="password" name="current_password"
                                            class="form-control @error('current_password') is-invalid @enderror"
                                            id="password" placeholder="Current Password">
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password">New Password</label>
                                        <input type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror" id="password"
                                            placeholder="New Password">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" placeholder="Confirm Password">
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary mt-4">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
