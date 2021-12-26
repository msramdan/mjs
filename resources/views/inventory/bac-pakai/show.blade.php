@extends('layouts.master')
@section('title', 'Detail BAC Pakai')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('bac_pakai_show') }}

        @include('inventory.bac-pakai.include.cart')
    </div>
@endsection
