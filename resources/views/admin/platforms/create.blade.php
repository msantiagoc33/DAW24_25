@extends('adminlte::page')

@section('title', 'Platforms-create')

@section('content_header')

@stop

@section('content')
    @can('Administrador')
        <br>
        @if (session('info'))
            <div class="alert alert-success">
                <strong>{{ session('info') }}</strong>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5>Crear una nueva plataforma.</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.platforms.store') }}">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Nombre de la plataforma"
                            value="{{ old('name') }}" required oninput="this.value = this.value.toUpperCase()">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Grabar</button>
                        <a href="{{ route('admin.platforms.index') }}" class="btn btn-secondary">Volver</a>
                    </div>

                </form>
            </div>
        </div>
    @else
        @php
            $nombre = auth()->user()->name; // Obtener el nombre del usuario
            $corto = strstr($nombre, ' ', true); // Obtener la parte antes del primer espacio
        @endphp
        <h2>{{ $corto }} no tiene permisos para crear plataformas.</h2>
    @endcan
@stop

@section('css')
@stop

@section('js')
@stop
