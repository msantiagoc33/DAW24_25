@extends('adminlte::page')

@section('title', 'Concepto-crear')

@section('content_header')

@stop

@section('content')
    <br>
    @can('Administrador')
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


        <div class="card">
            <div class="card-header">
                <h5>Dar de alta a un nuevo concepto para facturas</h5>
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
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Grabar</button>
                <a href="{{ route('admin.concepts.index') }}" class="btn btn-secondary">Volver</a>
            </div>
            </form>
        </div>
        </div>
    @else
        @php
            $nombre = auth()->user()->name; // Obtener el nombre del usuario
            $corto = strstr($nombre, ' ', true); // Obtener la parte antes del primer espacio
        @endphp
        <h2>{{ $corto }} no tiene permisos para crear conceptos.</h2>
    @endcan

@stop

@section('css')
@stop

@section('js')
@stop
