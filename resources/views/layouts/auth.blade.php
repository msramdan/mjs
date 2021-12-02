<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>@yield('title') - {{ config('app.name') }}</title>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
<meta content="" name="description" />
<meta content="" name="author" />

<link href="{{ asset('template/assets/css/vendor.min.css') }}" rel="stylesheet" />
<link href="{{ asset('template/assets/css/transparent/app.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="" crossorigin="anonymous" referrerpolicy="no-referrer" />


</head>
<body class='pace-top'>

<div class="app-cover"></div>


<div id="app" class="app">

<div class="login login-v2 fw-bold">

<div class="login-cover">
<div class="login-cover-img" style="background-image: url({{ asset('template/assets/img/login-bg/login-bg-17.jpg') }})" data-id="login-cover-image"></div>
<div class="login-cover-bg"></div>
</div>


<div class="login-container">

<div class="login-header">
<div class="brand">
<div class="d-flex align-items-center">
<span class="logo"></span> {{ config('app.name') }}
</div>
<small>Login to your account</small>
</div>
<div class="icon">
<i class="fa fa-lock"></i>
</div>
</div>


<div class="login-content">
<form action="" method="GET">

    <div class="form-floating mb-20px">
    <input type="text" class="form-control fs-13px h-45px border-0" placeholder="Email Address" id="emailAddress" />
    <label for="emailAddress" class="d-flex align-items-center text-gray-300 fs-13px">Email Address</label>
    @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    </div>

    <div class="form-floating mb-20px">
    <input type="password" class="form-control fs-13px h-45px border-0" placeholder="Password" />
    <label for="emailAddress" class="d-flex align-items-center text-gray-300 fs-13px">Password</label>
    @error('password')
        <span class="invalid-feedback" role="alert">
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
{{-- <div class="text-gray-500">
@if (Route::has('password.request'))
        <a class="text-white" href="{{ route('password.request') }}">
            {{ __('Forgot Your Password?') }}
        </a>
    @endif
</div> --}}


</form>
</div>

</div>

</div>


<div class="login-bg-list clearfix">
<div class="login-bg-list-item active"><a href="javascript:;" class="login-bg-list-link" data-toggle="login-change-bg" data-img="{{ asset('template/assets/img/login-bg/login-bg-17.jpg') }}" style="background-image: url({{ asset('template/assets/img/login-bg/login-bg-17.jpg') }})"></a></div>
<div class="login-bg-list-item"><a href="javascript:;" class="login-bg-list-link" data-toggle="login-change-bg" data-img="{{ asset('template/assets/img/login-bg/login-bg-16.jpg') }}" style="background-image: url({{ asset('template/assets/img/login-bg/login-bg-16.jpg') }})"></a></div>
<div class="login-bg-list-item"><a href="javascript:;" class="login-bg-list-link" data-toggle="login-change-bg" data-img="{{ asset('template/assets/img/login-bg/login-bg-15.jpg') }}" style="background-image: url({{ asset('template/assets/img/login-bg/login-bg-15.jpg') }})"></a></div>
<div class="login-bg-list-item"><a href="javascript:;" class="login-bg-list-link" data-toggle="login-change-bg" data-img="{{ asset('template/assets/img/login-bg/login-bg-14.jpg') }}" style="background-image: url({{ asset('template/assets/img/login-bg/login-bg-14.jpg') }})"></a></div>
<div class="login-bg-list-item"><a href="javascript:;" class="login-bg-list-link" data-toggle="login-change-bg" data-img="{{ asset('template/assets/img/login-bg/login-bg-13.jpg') }}" style="background-image: url({{ asset('template/assets/img/login-bg/login-bg-13.jpg') }})"></a></div>
<div class="login-bg-list-item"><a href="javascript:;" class="login-bg-list-link" data-toggle="login-change-bg" data-img="{{ asset('template/assets/img/login-bg/login-bg-12.jpg') }}" style="background-image: url({{ asset('template/assets/img/login-bg/login-bg-12.jpg') }})"></a></div>
</div>



<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top" data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>

</div>


<script src="{{ asset('template/assets/js/vendor.min.js') }}" type="c8b7670c166076c88715b305-text/javascript"></script>
<script src="{{ asset('template/assets/js/app.min.js') }}" type="c8b7670c166076c88715b305-text/javascript"></script>


<script src="{{ asset('template/assets/js/demo/login-v2.demo.js') }}" type="c8b7670c166076c88715b305-text/javascript"></script>

<script src="../../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="c8b7670c166076c88715b305-|49" defer=""></script><script defer src="https://static.cloudflareinsights.com/beacon.min.js/v64f9daad31f64f81be21cbef6184a5e31634941392597" integrity="sha512-gV/bogrUTVP2N3IzTDKzgP0Js1gg4fbwtYB6ftgLbKQu/V8yH2+lrKCfKHelh4SO3DPzKj4/glTO+tNJGDnb0A==" data-cf-beacon='{"rayId":"6b731147af5e6bc3","version":"2021.11.0","r":1,"token":"4db8c6ef997743fda032d4f73cfeff63","si":100}' crossorigin="anonymous"></script>
</body>
</html>
