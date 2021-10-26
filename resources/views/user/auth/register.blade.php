@extends('layouts.master2')

@section('title')
   {{__('Registration')}}
@stop
@section('css')
@livewireStyles()
@endsection
@section('content')
    @livewire('user-register')
@endsection
@section('js')
@livewireScripts()

@endsection