@extends('adminlte::page')

{{-- Vista de creación de un apartamento --}}

@section('title', 'Apartments-Crear')

@section('content_header')

@stop

@section('content')
    {{-- Verificar que el usuario sea administrador --}}
    @can('Administrador')
        <br>
        {{-- Mostar mensajes de error o de exito al grabar un apartamento --}}
        <div class="erroresMensajes">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {{-- Si hay un mensaje de sesion 'info', se muestra --}}
            @if (session('info'))
                <div class="alert alert-success">
                    <strong>{{ session('info') }}</strong>
                </div>
            @endif
            {{-- Si hay un mensaje de sesion 'success', se muestra --}}
            @if (session('success'))
                <div class="alert alert-success">
                    <strong>{{ session('success') }}</strong>
                </div>
            @endif
        </div>
        {{-- Formulario para dar de alta un nuevo apartamento --}}
        <div class="card">
            <div class="card-header bg-azul-claro text-center text-white fs-1">
                Dar de alta un nuevo apartamento
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
        @include('admin.index')
    @endcan
@stop

@section('css')
@stop

@section('js')
@stop
