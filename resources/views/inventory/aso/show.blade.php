@extends('layouts.master')
@section('title', 'Detail purchase')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('purchase_show') }}

        <div class="row">
            @include('inventory.aso.include.bac-info')

            @include('inventory.aso.include.cart')
        </div>
    </div>
@endsection
