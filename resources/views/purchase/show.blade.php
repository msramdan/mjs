@extends('layouts.master')
@section('title', 'Detail purchase')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('purchase_show') }}

        <form action="{{ route('purchase.store') }}" method="POST" id="form-purchase">
            @csrf
            @method('POST')
            <div class="row">
                @include('purchase.include.request-info')

                @include('purchase.include.cart')
            </div>
        </form>
    </div>
@endsection
