@extends('adminlte::page')

@section('title', 'Historico-index')

@section('content_header')
    <br>
    @can('Consultor')
        {{-- Carga el componente historico-index --}}
        @livewire('admin.historico-index')
    @else
        {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
        @include('admin.index')
    @endcan
@stop

@section('css')

@stop

@section('js')

@stop
