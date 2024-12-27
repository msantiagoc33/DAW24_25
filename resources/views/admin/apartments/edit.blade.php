@extends('adminlte::page')

{{-- Página de edición de un apartamento --}}

@section('title', 'Apartments-edit')

@section('content_header')

@stop

@section('content')
    {{-- Verificar que el usuario tenga el rol de Administrador  --}}
    @if (auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Editor'))
        <div class="erroresMensajes">
            {{-- Mostrar errores de validación si existen  --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {{-- Mostrar mensaje de éxito si existe  --}}
            @if (session('success'))
                <div class="alert alert-success">
                    <strong>{{ session('success') }}</strong>
                </div>
            @endif
            {{-- Mostrar mensaje de info si existe --}}
            @if (session('info'))
                <div class="alert alert-success">
                    <strong>{{ session('info') }}</strong>
                </div>
            @endif
        </div>
        {{-- Formulario para editar los datos de un apartamento --}}
        <div class="card">
            <div class="card-header bg-azul-claro text-center text-white fs-1">
                Modificar apartamento {{ $apartment->name }}
            </div>
            <form method="POST" action="{{ route('admin.apartments.update', $apartment->id) }}">
                {{-- token de seguridad --}}
                @csrf
                @method('PUT')

                <div class="card-body">
                    {{-- Campo para editar el nombre del apartamento --}}
                    <div class="form-group">
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $apartment->name) }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Campo para editar la dirección del apartamento --}}
                    <div class="form-group">
                        <input type="text" name="address" class="form-control"
                            value="{{ old('address', $apartment->address) }}">
                        @error('address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Campo para editar la descripción del apartamento --}}
                    <div class="form-group">
                        <input type="text" name="description" class="form-control"
                            value="{{ old('description', $apartment->description) }}">
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Campo para editar las habitaciones del apartamento --}}
                    <div class="form-group">
                        <input type="text" name="rooms" class="form-control"
                            value="{{ old('rooms', $apartment->rooms) }}">
                        @error('rooms')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Campo para editar la capacidad del apartamento --}}
                    <div class="form-group">
                        <input type="text" name="capacidad" class="form-control"
                            value="{{ old('capacidad', $apartment->capacidad) }}">
                        @error('capacidad')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Botones de acción --}}
                <div class="card-footer text-right">
                    {{-- Botón para actualizar los datos --}}
                    <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                    {{-- Boton para volver al listado de apartamento --}}
                    <a href="{{ route('admin.apartments.index') }}" class="btn btn-secondary btn-sm">Volver</a>
                </div>
            </form>
        </div>
    @else
        {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
        @include('admin.index')
    @endif

@stop

@section('css')
    {{-- El campo  que tiene el foco se le cambio el color de fondo --}}
    <style>
        .custom-input:focus {
            background-color: #cce5ff;
            outline: none;
        }
    </style>
@stop

@section('js')

@stop
