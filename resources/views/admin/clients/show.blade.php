@extends('adminlte::page')
{{-- Vista para mostrar en detalle un cliente --}}
@section('title', 'Client-Show')

@section('content_header')

@stop

@section('content')
    {{-- Sólo tendrán acceso los usuarios con el rol de Consultor --}}
    @if (auth()->user()->hasRole('Administrador') ||
            auth()->user()->hasRole('Editor') ||
            auth()->user()->hasRole('Consultor'))
        <div class="card">
            <div class="card-header bg-azul-claro text-center text-white fs-1">
                Ficha del cliente {{ $client->name }}
            </div>
            <div class="card-body bg-slate-400">
                <h2>{{ $client->name }} - ({{ $client->pais->nombre }})</h2>
                <h3><i class="fa-solid fa-phone mr-3 text-primary"></i>{{ $client->phone }}</h3>
                <hr>
                <h2><i class="fa-solid fa-address-book text-primary"></i></h2>
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
        {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
        @include('admin.index')
    @endif
@stop

@section('css')

@stop

@section('js')
@stop
