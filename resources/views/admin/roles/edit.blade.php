@extends('adminlte::page')

{{-- Vista para la edición de un rol --}}
@section('title', 'Edit-rol')

@section('content_header')
@stop

@section('content')
    {{-- Sólo los usuarios con el rol de Administrador pueden editar rol --}}
    @can('Administrador')
        {{-- Muestra posibles mensajes --}}
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
                Modificar rol y/o permisos
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
                            <h2>Permisos</h2>
                        </label>
                        <div class="grid-container" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
                            @foreach ($permisos as $permiso)
                                <div>
                                    <label>
                                        <input type="checkbox" name="permissions[]" value="{{ $permiso->id }}"
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
            {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
            @include('admin.index');
        @endcan
    @stop

    @section('css')
    @stop

    @section('js')
    {{-- Sitúa el cursor en el campo nombre del rol, al final del nombre, al cargar la página --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                var inputField = document.getElementById('name');

                // Establecer el foco y colocar el cursor al final
                inputField.focus();
                inputField.setSelectionRange(inputField.value.length, inputField.value.length);
            });
        </script>
    @stop
