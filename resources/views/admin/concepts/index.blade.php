@extends('adminlte::page')

@section('title', 'Conceptos-index')

@section('content_header')
<style>
    .table-striped tbody tr:nth-of-type(even) {
        background-color: #cce5ff;
        /* Azul claro */
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: white;
        /* Blanco */
    }
</style>
@stop

@section('content')
    <br>
    @can('Consultor')
        @livewire('admin.concepts-index')
    @else
        @include('admin.index');
    @endcan
@stop

@section('css')
@stop

@section('js')
@stop
