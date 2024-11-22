@extends('adminlte::page')

@section('title', 'Admin-index')

@section('content_header')

@stop

@section('content')
    <br>
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    @can('Administrador')
    <div class="card-header">
        <h1>Crear nuevo usuario</h1>
    </div>
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="name" class="form-control ml-10" placeholder="Nombre"
                            value="{{ old('name') }}" required oninput="this.value = this.value.toUpperCase()">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control ml-10" placeholder="Correo electrónico"
                            value="{{ old('email') }}" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Confirmar Contraseña" required>
                        @error('password_confirmation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Grabar</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Volver</a>
                    </div>
                </form>
            </div>
        </div>
    @else
        @php
            $nombre = auth()->user()->name; // Obtener el nombre del usuario
            $corto = strstr($nombre, ' ', true); // Obtener la parte antes del primer espacio
        @endphp
        <h2>{{ $corto }} no tiene permisos para crear usuarios.</h2>
        <!-- Imprimir el valor de $corto correctamente -->
    @endcan


@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')

@stop
