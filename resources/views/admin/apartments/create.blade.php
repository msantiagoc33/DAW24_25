@extends('adminlte::page')

@section('title', 'Apartments-index')

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
                <h2>Dar de alta a un nuevo apartamento.</h2>
            </div>
            <form method="POST" action="{{ route('admin.apartments.store') }}">
                @csrf

                <div class="card-body">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Nombre del apartamento"
                            value="{{ old('name') }}" required oninput="this.value = this.value.toUpperCase()">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" name="address" class="form-control" placeholder="Dirección"
                            value="{{ old('address') }}" required>
                        @error('address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" name="description" class="form-control" placeholder="Descripción"
                            value="{{ old('description') }}" required>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" name="rooms" class="form-control" placeholder="Número de habitaciones"
                            value="{{ old('rooms') }}" required>
                        @error('rooms')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" name="capacidad" class="form-control" placeholder="Capacidad"
                            value="{{ old('capacidad') }}" required>
                        @error('capacidad')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Grabar</button>
                    <a href="{{ route('admin.apartments.index') }}" class="btn btn-secondary">Volver</a>
                </div>
            </form>
        </div>
    @else
        @php
            $nombre = auth()->user()->name; // Obtener el nombre del usuario
            $corto = strstr($nombre, ' ', true); // Obtener la parte antes del primer espacio
        @endphp
        <h2>{{ $corto }}, no tiene permiso para crear apartamentos.</h2>
    @endcan
@stop



@section('css')
@stop

@section('js')
@stop
