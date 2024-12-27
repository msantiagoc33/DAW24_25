@extends('adminlte::page')
{{-- Vista de edición de una plataforma --}}
@section('title', 'Platform-edit')

@section('content_header')

@stop

@section('content')
    {{-- Sólo los usuarios con el rol de Administrador acceden a esta vista --}}
    @if (auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Editor'))
        {{-- Mostrar posibles mensajes --}}
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
                Modificar la plataform: {{ $platform->name }}
            </div>

            <form action="{{ route('admin.platforms.update', $platform->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $platform->name) }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                        <a href="{{ route('admin.platforms.index') }}" class="btn btn-secondary btn-sm">Volver</a>
                    </div>
                </div>

            </form>
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
