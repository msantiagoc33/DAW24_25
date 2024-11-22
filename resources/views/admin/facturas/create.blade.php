@extends('adminlte::page')

@section('title', 'Admin-index')

@section('content_header')

@stop

@section('content')
    <br>
    @can('Administrador')
        <!-- Mostrar el mensaje de éxito -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Mostrar el mensaje de error -->
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Mostrar el mensaje de éxito -->
        @if (session('info'))
            <div class="alert alert-success">
                <strong>{{ session('info') }}</strong>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5>Dar de alta a una nueva factura</h5>
            </div>
            <form action="{{ route('admin.facturas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="fecha">Fecha de la factura</label>
                        <input type="date" name="fecha" id="fecha" class="form-control"
                            placeholder="Fecha de la facturas" required>
                        @error('fecha')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="importe">Importe</label>
                        <input type="number" name="importe" id="importe" step="any" placeholder="Ejemplo: 125.36"
                            required>
                        @error('import')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="file_uri">Subir Archivo (PDF, etc.):</label>
                        <input type="file" name="file_uri" class="form-control">
                        @error('file_uri')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="apartamento">Selecciona un Apartamento:</label>
                        <select name="apartment_id" class="form-control" required>
                            <option value="">Selecciona un apartamento...</option>
                            @foreach ($apartamentos as $apartamento)
                                <option value="{{ $apartamento->id }}">{{ $apartamento->name }}</option>
                            @endforeach
                        </select> 
                    </div>

                    <div class="form-group">
                        <label for="conceptos">Selecciona el/los conceptos:</label>
                        <select name="conceptos[]" id="conceptos" class="form-control" multiple>
                            @foreach ($conceptos as $concepto)
                                <option value="{{ $concepto->id }}">{{ $concepto->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="notas">Nota adicional</label>
                        <input type="text" name="notas" id="notas" step="any" placeholder="Notas adicionales">
                        @error('notas')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Grabar</button>
                    <a href="{{ route('admin.facturas.index') }}" class="btn btn-secondary">Volver</a>
                </div>
            </form>
        </div>
    @else
        @php
            $nombre = auth()->user()->name; // Obtener el nombre del usuario
            $corto = strstr($nombre, ' ', true); // Obtener la parte antes del primer espacio
        @endphp
        <h2>{{ $corto }} no tiene permisos para crear facturas.</h2>
    @endcan
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')

@stop
