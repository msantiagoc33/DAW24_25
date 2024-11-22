@extends('adminlte::page')

@section('title', 'Admin-index')

@section('content_header')
    @can('admin.client.index')
        <h1>Listado de clientes</h1>
    @else
        @php
            $nombre = auth()->user()->name; // Obtener el nombre del usuario
            $corto = strstr($nombre, ' ', true); // Obtener la parte antes del primer espacio
        @endphp
        <p>Bienvenido {{ $corto }}</p> <!-- Imprimir el valor de $corto correctamente -->
    @endcan
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
