@extends('layouts.auth')
@section('title')
    {{ __('Login') }}
@endsection
@section('content')
<div class="login-content">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-floating mb-20px">
        <input type="email" name="email" class="form-control  @error('email') is-invalid @enderror fs-13px h-45px" placeholder="Email Address" id="emailAddress"  value="{{ old('email') }}" required autocomplete="email" autofocus />
        {{-- <label for="emailAddress" class="d-flex align-items-center text-gray-300 fs-13px">Email Address</label> --}}
        @error('email')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        </div>

        <div class="form-floating mb-20px">
        <input type="password" class="form-control @error('password') is-invalid @enderror fs-13px h-45px" placeholder="Password"  name="password" required autocomplete="current-password" />
        {{-- <label for="emailAddress" class="d-flex align-items-center text-gray-300 fs-13px">Password</label> --}}
        @error('password')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        </div>

    <div class="form-check mb-20px">
        <input class="form-check-input border-0" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
        <label class="form-check-label fs-13px text-gray-500" for="remember">
            {{ __('Remember Me') }}
        </label>
    </div>

    <div class="mb-20px">
    <button type="submit" class="btn btn-success d-block w-100 h-45px btn-lg">
        {{ __('Login') }}
    </button>
    </div>

    </form>
    </div>
@endsection
