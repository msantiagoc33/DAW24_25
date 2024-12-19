@extends('adminlte::page')
{{-- Vista para mostar un concepto en particular --}}
@section('title', 'Concepto-show')

@section('content_header')

@stop

@section('content')
    @can('Consultor')
        <div class="card">
            <div class="card-header bg-azul-claro text-center text-white fs-1">
                Ficha de concepto
            </div>
            <div class="card-body bg-slate-400">
                <h2>{{ $concept->name }}</h2>
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('admin.concepts.index') }}" class="btn btn-secondary btn-sm">Volver</a>
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
