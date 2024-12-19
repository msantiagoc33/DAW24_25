@extends('adminlte::page')

{{-- Vista de una plataforma en particular --}}
@section('title', 'Platforms-Show')

@section('content_header')

@stop

@section('content')
    {{-- Sólo los usuarios con el rol de Consultor pueden ver esta vista --}}
    @can('Consultor')
        <div class="card">
            <div class="card-header bg-azul-claro text-center text-white fs-1">
                Ficha de la plataforma: {{ $platform->name }}
            </div>
            <div class="card-body bg-slate-400">
                <h2>{{ $platform->name }}</h2>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.platforms.index') }}" class="btn btn-secondary btn-sm float-right">Volver</a>
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
