@extends('layouts.master')
@section('title', 'Detail Received')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('received_show') }}

        <div class="row">
            @include('inventory.received.include.bac-info')

            @include('inventory.received.include.cart')
        </div>
    </div>
@endsection
