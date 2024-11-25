@extends('adminlte::page')

@section('title', 'Client-Show')

@section('content_header')


@stop

@section('content')
    @can('Consultor')
        <div class="card">
            <div class="card-body bg-slate-400">
                <h2>{{ $client->name }} - ({{ $client->pais->nombre }})</h2>
                <h3><i class="fa-solid fa-phone mr-3 text-primary"></i>{{ $client->phone }}</h3>
                <hr><h2><i class="fa-solid fa-address-book text-primary"></i></h2>
                <h3>{{ $client->calle_numero }}</h3>
                <h3>{{ $client->cp }}-{{ $client->ciudad }}</h3>
                <h3>{{ $client->provincia }}</h3>
                <hr>
                <h3><i class="fa-solid fa-passport mr-3 text-primary"></i>{{ $client->passport }}</h3>
                
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary btn-sm">Volver</a>
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
