@extends('adminlte::page')

@section('title', 'Historico-index')

@section('content_header')
    <br>
    @can('Consultor')
        @livewire('admin.historico-index')
    @else
        @include('admin.index')
    @endcan
@stop

@section('css')

@stop

@section('js')

@stop