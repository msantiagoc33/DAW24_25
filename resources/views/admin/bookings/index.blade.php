@extends('adminlte::page')

@section('title', 'Admin-index')

@section('content_header')
    <br>
    @can('Consultor')
        @livewire('admin.bookings-index')
    @else
        @include('admin.index')
    @endcan
@stop

@section('css')

@stop

@section('js')

@stop
