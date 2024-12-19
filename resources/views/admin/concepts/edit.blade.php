@extends('adminlte::page')
{{-- Vista de edición de un concepto --}}
@section('title', 'Edit-concepto')

@section('content_header')

@stop

@section('content')
    {{-- Sólo los usuarios con el rol de Aministrador puden editar conceptos --}}
    @can('Administrador')
        {{-- Vista de posibles mensajes --}}
        <div class="erroresMensaje">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('info'))
                <div class="alert alert-success">
                    <strong>{{ session('info') }}</strong>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    <strong>{{ session('success') }}</strong>
                </div>
            @endif
        </div>

        <div class="card">
            <div class="card-header bg-azul-claro text-center text-white fs-1">
                Modificar concepto de facturas.
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('admin.concepts.update', $concept->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <input type="text" name="name" id="concepto" value="{{ old('name', $concept->name) }}"
                            oninput="this.value = this.value.toUpperCase()">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Botones de acción --}}
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                        <a href="{{ route('admin.concepts.index') }}" class="btn btn-secondary btn-sm">Volver</a>
                    </div>
                </form>
            </div>
        @else
            {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
            @include('admin.index')
        @endcan
    @stop

    @section('css')
    @stop

    @section('js')
    {{-- Establece el foco en el campo concepto al cargar la página --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var inputField = document.getElementById('concepto');

                // Establecer el foco y colocar el cursor al final
                inputField.focus();
                inputField.setSelectionRange(inputField.value.length, inputField.value.length);
            });
        </script>
    @stop
