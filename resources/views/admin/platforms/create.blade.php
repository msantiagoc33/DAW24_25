@extends('adminlte::page')
{{-- Vista para la creación de una plataforma --}}
@section('title', 'Platforms-create')

@section('content_header')
@stop

@section('content')
    {{-- Sólo el usuario con el rol Administrador accederá a esta vista --}}
    @can('Administrador')
        <br>
        {{-- Mostrar los posibles mensajes --}}
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

        <div class="card">
            <div class="card-header bg-azul-claro text-center text-white fs-1">
                Crear una nueva plataforma.
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
        {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
        @include('admin.index')
    @endcan
@stop

@section('css')
@stop

@section('js')
@stop
