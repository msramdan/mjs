@extends('layouts.master')
@section('title', 'Detail Sale')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('sale_show') }}

        <form action="{{ route('sale.store') }}" method="POST" id="form-sale">
            @csrf
            @method('POST')
            <div class="row">
                @include('sale.sale.include.spal-info')

                @include('sale.sale.include.cart')
            </div>
        </form>
    </div>
@endsection
