@extends('layouts.master')
@section('title', 'Detail Billing')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('billing_show') }}

        <div class="row">
            @include('accounting.billing.include.purchase-info')

            @include('accounting.billing.include.cart')
        </div>
    </div>
@endsection
