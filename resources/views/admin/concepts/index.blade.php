@extends('adminlte::page')

@section('title', 'Conceptos-index')

@section('content_header')

@stop

@section('content')
    <br>
    @can('Consultor')
        @livewire('admin.concepts-index')
    @else
        {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
        @include('admin.index');
    @endcan
@stop

@section('css')
@stop

@section('js')
@stop
