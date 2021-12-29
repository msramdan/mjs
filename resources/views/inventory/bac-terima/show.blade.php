@extends('layouts.master')
@section('title', 'Detail BAC Terima')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('bac_terima_show') }}

        <div class="row">
            <div class="col-md-3">
                @include('inventory.bac-terima.include.purchase-info')
            </div>

            <div class="col-md-9">
                @include('inventory.bac-terima.include.cart')
            </div>
        </div>
    </div>
@endsection
