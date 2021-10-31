@extends('layouts.master2')

@section('title')
   {{__('Login')}}
@stop
@section('css')
@livewireStyles()
@endsection
@section('content')
    @livewire('user-login')
@endsection
@section('js')
@livewireScripts()

@endsection