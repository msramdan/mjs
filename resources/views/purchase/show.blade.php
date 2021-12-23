@extends('layouts.master')
@section('title', 'Detail purchase')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('purchase_show') }}

        <div class="row">
            @include('purchase.include.request-info')

            @include('purchase.include.cart')
        </div>
    </div>
@endsection
