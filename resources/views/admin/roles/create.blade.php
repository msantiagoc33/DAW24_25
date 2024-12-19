@extends('adminlte::page')
{{-- Vista para la creación de rol --}}
@section('title', 'Roles-Crear')

@section('content_header')

@stop

@section('content')
    {{-- Sólo los usuarios con el rol de Administrador pueden crear roles --}}
    @can('Administrador')
        <br>
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
                Dar de alta un nuevo rol y sus permisos
            </div>

            <form method="POST" action="{{ route('roles.store') }}">
                @csrf

                <div class="card-body">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" id="rolName" placeholder="Nombre del rol"
                            value="{{ old('name') }}" required oninput="this.value = this.value.toUpperCase()">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label for="permissions">
                            <h2>Selecciona los Permisos a asignar al Rol</h2>
                        </label>
                        <div class="grid-container" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                            @foreach ($permisos as $permiso)
                                <div>
                                    <label>
                                        {{-- Se podrán seleccionar varios permisos --}}
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
        {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
        @include('admin.index');
    @endcan
@stop



@section('css')
@stop

@section('js')
{{-- Sitúa el foco en el campo nombre del rol al cargar la página --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('rolName').focus();
        });
    </script>

@stop
