<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>@yield('title') - {{ config('app.name') }}</title>
    {{-- meta --}}
    @include('layouts._auth.meta')
    {{-- style --}}
    @include('layouts._auth.style')

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
                    <div class="icon"><i class="fa fa-lock"></i></div>
                </div>
                {{-- content --}}
                @yield('content')
            </div>
            </div>
            {{-- BG --}}
            @include('layouts._auth.bg')
            <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top" data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
        </div>
    {{-- Script --}}
    @include('layouts._auth.script')
    </body>
</html>
