@extends('adminlte::page')

{{-- Vistas de todos los usuarios  --}}
@section('title', 'Users-index')

@section('content_header')

@stop

@section('content')
    <br>
    {{-- Sólo los usuarios con el rol de Administrador pueden ver este listado de usuarios --}}
    @can('Administrador')
        {{-- Vista de posibles mensajes --}}
        <div class="errores">
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
            <!-- Mostrar el mensaje de éxito -->
            @if (session('info'))
                <div class="alert alert-success">
                    <strong>{{ session('info') }}</strong>
                </div>
            @endif
            <!-- Mostrar el mensaje de error -->
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <div class="card-header bg-azul-claro text-center text-white fs-1">
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
        {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
        @include('admin.index');
    @endcan


@stop

@section('css')

@stop

@section('js')

@stop
