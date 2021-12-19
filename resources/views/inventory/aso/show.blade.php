@extends('layouts.master')
@section('title', 'Detail ASO')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('aso_show') }}

        <div class="row">
            @include('inventory.aso.include.bac-info')

            @include('inventory.aso.include.cart')
        </div>
    </div>
@endsection
