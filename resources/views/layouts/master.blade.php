<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') - {{ config('app.name') }}</title>
    {{-- Meta --}}
    @include('layouts._dashboard.meta')

    {{-- style --}}
    @include('layouts._dashboard.style')

    @stack('css')
</head>

<body>
    <div class="app-cover"></div>
    {{-- Spinner --}}
    @include('layouts._dashboard.spinner')

    <div id="app" class="app app-header-fixed app-sidebar-fixed">
        {{-- Header --}}
        @include('layouts._dashboard.header')

        {{-- Sidebar --}}
        @include('layouts._dashboard.sidebar')

        <div class="app-sidebar-bg"></div>
        <div class="app-sidebar-mobile-backdrop"><a href="#" data-dismiss="app-sidebar-mobile" class="stretched-link"></a>
        </div>

        {{-- Content --}}
        @yield('content')

        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top"
            data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
    </div>

    {{-- Script --}}
    @include('layouts._dashboard.script')

    @stack('js')

</body>

</html>
