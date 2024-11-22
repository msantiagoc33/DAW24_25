@extends('adminlte::page')

@section('title', 'Admin-index')

@section('content_header')

@stop

@section('content')
    @can('Consultor')
        <div class="card">
            <div class="card-header">
                <h2 class="text-center">Ficha de concepto</h2>
            </div>
            <div class="card-body bg-slate-400">
                <h2>{{ $concept->name }}</h2>
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('admin.concepts.index') }}" class="btn btn-secondary btn-sm">Volver</a>
            </div>
        </div>
    @else
        @php
            $nombre = auth()->user()->name; // Obtener el nombre del usuario
            $corto = strstr($nombre, ' ', true); // Obtener la parte antes del primer espacio
        @endphp
        <h2>A usuario {{ $corto }} no se le ha asignado ningún rol aún.</h2>
    @endcan
@stop

@section('css')
@stop

@section('js')
    <script></script>
@stop
