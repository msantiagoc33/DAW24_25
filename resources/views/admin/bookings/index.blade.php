@extends('adminlte::page')

@section('title', 'Admin-index')

@section('content_header')
    @can('admin.users.index')
        <h1>Lista de usuarios</h1>
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
    @livewire('admin.users-index')

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')

@stop
