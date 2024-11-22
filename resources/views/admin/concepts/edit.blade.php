@extends('adminlte::page')

@section('title', 'Edit-concepto')

@section('content_header')

@stop

@section('content')
    @can('Administrador')
        @if (session('info'))
            <div class="alert alert-success">
                <strong>{{ session('info') }}</strong>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5>Modificar concepto de facturas.</h5>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('admin.concepts.update', $concept->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <input type="text" name="name" id="concepto" value="{{ old('name', $concept->name) }}" oninput="this.value = this.value.toUpperCase()">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                        <a href="{{ route('admin.concepts.index') }}" class="btn btn-secondary btn-sm">Volver</a>
                    </div>
                </form>
            </div>
        @else
            @php
                $nombre = auth()->user()->name; // Obtener el nombre del usuario
                $corto = strstr($nombre, ' ', true); // Obtener la parte antes del primer espacio
            @endphp
            <h2>{{ $corto }} no tiene permisos para crear editar conceptos de factura.</h2>
        @endcan
    @stop

    @section('css')
    @stop

    @section('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var inputField = document.getElementById('concepto');

                // Establecer el foco y colocar el cursor al final
                inputField.focus();
                inputField.setSelectionRange(inputField.value.length, inputField.value.length);
            });
        </script>
    @stop
