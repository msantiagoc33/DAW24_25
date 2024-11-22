@extends('adminlte::page')

@section('title', 'Edit-rol')

@section('content_header')

@stop

@section('content')
    @can('Administrador')
        @if (session('info'))
            <div class="alert alert-info">
                <strong>{{ session('info') }}</strong>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                <strong>{{ session('success') }}</strong>
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h5>Modificar Rol.</h5>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('roles.update', $rol->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <input type="text" name="name" id="name" value="{{ old('name', $rol->name) }}"
                            oninput="this.value = this.value.toUpperCase()">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Se cargan todos los permisos disponibles y se marcan los que tiene asignados el rol. --}}
                    <div class="form-group mt-3">
                        <label for="permissions">
                            <h2>Pemisos</h2>
                        </label>
                        <div class="grid-container" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                            @foreach ($permisos as $permiso)
                                <div>
                                    <label>
                                        <input type="checkbox" 
                                                name="permissions[]" 
                                                value="{{ $permiso->id }}"
                                                {{ $rol->permisos->pluck('id')->contains($permiso->id) ? 'checked' : '' }}>
                                        {{ $permiso->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-sm">Volver</a>
                    </div>
                </form>
            </div>
        @else
            @php
                $nombre = auth()->user()->name; // Obtener el nombre del usuario
                $corto = strstr($nombre, ' ', true); // Obtener la parte antes del primer espacio
            @endphp
            <h2>{{ $corto }} no tiene permisos para modificar roles.</h2>
        @endcan
    @stop

    @section('css')
    @stop

    @section('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var inputField = document.getElementById('name');

                // Establecer el foco y colocar el cursor al final
                inputField.focus();
                inputField.setSelectionRange(inputField.value.length, inputField.value.length);
            });
        </script>
    @stop
