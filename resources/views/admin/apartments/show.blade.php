@extends('adminlte::page')
{{-- Vista que muestra en detalle un apartamento --}}
@section('title', 'Apartment-show')

@section('content_header')

@stop

@section('content')
    {{-- Ficha de un apartamento accesible a todos los usuarios con rol de Consultor --}}
    @can('Consultor')
        <div class="card">
            <div class="card-header bg-azul-claro text-center text-white fs-1">
                <h2 class="text-center">Ficha del apartamento</h2>
            </div>

            <div class="card-body" style='background-color: #a1c8e2;'>
                <h2><i>{{ $apartment->name }}</i></h2>
                <hr>
                <h3>Dirección: {{ $apartment->address }}</h3>
                <h3>Descripción: {{ $apartment->description }}</h3>
                <h3>Habitaciones: {{ $apartment->rooms }}</h3>
                <h3>Capacidad: {{ $apartment->capacidad }}</h3>
            </div>

            {{-- Botón que devuelve la lista de todos los apartamento --}}
            <div class="card-footer text-right">
                <a href="{{ route('admin.apartments.index') }}" class="btn btn-secondary btn-sm">Volver</a>
            </div>
        </div>
    @else
        {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
        @include('admin.index')
    @endcan
@stop

@section('css')
@stop

@section('js')
@stop
