@extends('adminlte::page')

@section('title', 'Conceptos-index')

@section('content_header')

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
