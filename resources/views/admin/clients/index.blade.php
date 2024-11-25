@extends('adminlte::page')

@section('title', 'Admin-index')

@section('content_header')
    
@stop

@section('content')
    <br>
    @can('Consultor')
        @livewire('admin.clients-index')
    @else
        @include('admin.index')
    @endcan

@stop

@section('css')

@stop

@section('js')

@stop
