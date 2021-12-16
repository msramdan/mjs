@extends('layouts.master')
@section('title', 'Detail BAC Terima')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('bac_terima_show') }}

        @include('inventory.bac-terima.include.cart')
    </div>
@endsection
