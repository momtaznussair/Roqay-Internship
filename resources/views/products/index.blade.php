@extends('layouts.master')
@section('title')
    {{__('Products')}}
@stop
@section('css')
<style>
    td{
        vertical-align: middle !important;
    }
</style>
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">{{__('Products')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Products List')}}</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- success message --}}
@if (session()->has('success'))
<script>
    window.onload = function() {
        notif({
            msg: "{{ session()->get('success') }}",
            type: "success"
        })
    }
</script>
@php
    Session::forget('success')
@endphp
@endif
<!-- row opened -->
<div class="row row-sm"></div>
    @livewire('product-component')
</div>
<!-- /row -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
