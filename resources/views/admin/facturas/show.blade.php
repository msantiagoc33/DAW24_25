@extends('adminlte::page')
{{-- Vista de una factura en particular --}}
@section('title', 'Factura-show')

@section('content_header')
@stop

@section('content')
    {{-- Sólo podrán ver esta vista los usuarios con el rol de Consultor --}}
    @if (auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Editor') || auth()->user()->hasRole('Consultor'))
        <div class="card">
            <div class="card-header bg-azul-claro text-center text-white fs-1">
                Ficha de factura
            </div>
            <div class="card-body bg-slate-400">
                
                {{-- Fecha, importe, apartamento y nota --}}
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="">Fecha</label>
                            <input value="{{ $factura->fecha }}" class="form-control custom-input" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="">Importe</label>
                            <input value="{{ $factura->importe }}" class="form-control custom-input" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="">Apartamento</label>
                            <input value="{{ $factura->apartment->name }}" class="form-control custom-input" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="">Nota</label>
                            <input value="{{ $factura->nota }}" class="form-control custom-input" readonly>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.facturas.index') }}" class="btn btn-secondary btn-sm mb-1">Volver</a>
                {{-- Factura --}}
                <div class="form-group">
                    <div class="row">                      
                        <div class="col-md-12">
                            <iframe src="{{ Storage::url($factura->file_uri) }}" width="100%" height="600px"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.facturas.index') }}" class="btn btn-secondary btn-sm">Volver</a>
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
