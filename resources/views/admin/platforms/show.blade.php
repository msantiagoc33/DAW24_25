@extends('adminlte::page')

@section('title', 'Platforms-index')

@section('content_header')

@stop

@section('content')
    @can('Consultor')
        <div class="card">
            <div class="card-header">
                <h2>Ficha de la plataforma</h2>
            </div>
            <div class="card-body bg-slate-400">
                <h2>{{ $platform->name }}</h2>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.platforms.index') }}" class="btn btn-secondary btn-sm float-right">Volver</a>
            </div>
        </div>
    @else
        @php
            $nombre = auth()->user()->name; // Obtener el nombre del usuario
            $corto = strstr($nombre, ' ', true); // Obtener la parte antes del primer espacio
        @endphp
        <h2>{{ $corto }} no tiene permisos para ver la ficha de la plataforma.  Es posible que aún no tenga asisgnado roles.</h2>
    @endcan
@stop

@section('css')
@stop

@section('js')
    <script></script>
@stop
