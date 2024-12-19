@extends('adminlte::page')
{{-- Vista de creación de un concepto para facturas --}}
@section('title', 'Concepto-crear')

@section('content_header')

@stop

@section('content')
    <br>
    {{-- Sólo podrán crear conceptos de factura los usuarios con el rol de Administrador --}}
    @can('Administrador')
    {{-- Presentación de posibles mensajes --}}
        <div class="erroresMensaje">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- Mostrar el mensaje de éxito -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Mostrar el mensaje de error -->
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <div class="card">
            <div class="card-header bg-azul-claro text-center text-white fs-1">
                Dar de alta un nuevo concepto para facturas
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('admin.concepts.store') }}">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Nombre del concepto"
                            value="{{ old('name') }}" required oninput="this.value = this.value.toUpperCase()">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
            </div>
            {{-- Botones de acción --}}
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Grabar</button>
                <a href="{{ route('admin.concepts.index') }}" class="btn btn-secondary">Volver</a>
            </div>
            </form>
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
