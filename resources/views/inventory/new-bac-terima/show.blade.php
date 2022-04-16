@extends('layouts.master')
@section('title', 'Detail New BAC Terima')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('new_bac_terima_show') }}

        @include('inventory.new-bac-terima.include.cart')
    </div>
@endsection
