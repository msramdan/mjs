@extends('layouts.master')
@section('title', 'Detail Invoice')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('invoice_show') }}

        <form action="{{ route('invoice.store') }}" method="POST" id="form-invoice">
            @csrf
            @method('POST')
            <div class="row">
                @include('accounting.invoice.include.sale-info')

                @include('accounting.invoice.include.cart')
            </div>
        </form>
    </div>
@endsection
