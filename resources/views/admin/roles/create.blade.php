@extends('adminlte::page')

@section('title', 'Roles')

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
                <h2>Dar de alta a un nuevo Rol.</h2>
            </div>
            <form method="POST" action="{{ route('roles.store') }}">
                @csrf

                <div class="card-body">
                    <div class="form-group">
                        <input type="text" name="role_name" class="form-control bg-secondary text-white" placeholder="Nombre del rol"
                            value="{{ old('role_name') }}" required oninput="this.value = this.value.toUpperCase()">
                        @error('role_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label for="permissions"><h2>Selecciona los Permisos a asignar al Rol</h2></label>
                        <div class="grid-container" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                            @foreach ($permisos as $permiso)
                                <div>
                                    <label>
                                        <input type="checkbox" name="permissions[]" value="{{ $permiso->id }}">
                                        {{ $permiso->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Grabar</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Volver</a>
                </div>
            </form>
        </div>
    @else
        @php
            $nombre = auth()->user()->name; // Obtener el nombre del usuario
            $corto = strstr($nombre, ' ', true); // Obtener la parte antes del primer espacio
        @endphp
        <h2>{{ $corto }}, no tiene permiso para crear roles.</h2>
    @endcan
@stop



@section('css')
@stop

@section('js')
@stop
