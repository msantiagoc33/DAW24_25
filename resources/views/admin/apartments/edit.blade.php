@extends('adminlte::page')

@section('title', 'Apartments-edit')

@section('content_header')

@stop

@section('content')
    @can('Administrador')
        @if (session('info'))
            <div class="alert alert-success">
                <strong>{{ session('info') }}</strong>
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h5>Modificar apartamento {{ $apartment->name }}</h5>
            </div>
            <form method="POST" action="{{ route('admin.apartments.update', $apartment->id) }}">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" value="{{ old('name', $apartment->name) }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="text" name="address" class="form-control"
                            value="{{ old('address', $apartment->address) }}">
                        @error('address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="text" name="description" class="form-control"
                            value="{{ old('description', $apartment->description) }}">
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="text" name="rooms" class="form-control" value="{{ old('rooms', $apartment->rooms) }}">
                    </div>
                    <div class="form-group">
                        <input type="text" name="capacidad" class="form-control"
                            value="{{ old('capacidad', $apartment->capacidad) }}">
                        @error('rooms')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                    <a href="{{ route('admin.apartments.index') }}" class="btn btn-secondary btn-sm">Volver</a>
                </div>
            </form>
        </div>
    @else
        @php
            $nombre = auth()->user()->name; // Obtener el nombre del usuario
            $corto = strstr($nombre, ' ', true); // Obtener la parte antes del primer espacio
        @endphp
        <h2>{{ $corto }} no tiene permisos para crear editar apartamentos.</h2>
    @endcan

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script></script>
@stop
