@extends('adminlte::page')
{{-- Vista para la creación de una factura --}}
@section('title', 'Factura-create')

@section('content_header')

@stop

@section('content')
    <br>
    {{-- Sólo visible para los usuarios con el rol de Administrador --}}
    @can('Administrador')
        {{-- Vista de posibles mensajes --}}
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
                Dar de alta una nueva factura
            </div>

            <form action="{{ route('admin.facturas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    {{-- Fecha de la factura --}}
                    <div class="form-group">
                        <label for="fecha">Fecha de la factura</label>
                        <input type="date" name="fecha" id="fecha" class="form-control"
                            placeholder="Fecha de la facturas" required>
                        @error('fecha')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Importe de la factura --}}
                    <div class="form-group">
                        <label for="importe">Importe</label>
                        <input type="number" name="importe" id="importe" step="any" placeholder="Ejemplo: 125.36"
                            required>
                        @error('import')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Seleccionar el archivo de la factura --}}
                    <div class="form-group">
                        <label for="file_uri">Subir Archivo (PDF, etc.):</label>
                        <input type="file" name="file_uri" class="form-control">
                        @error('file_uri')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Seleccionar el apartamento al que se le asigna la factura --}}
                    <div class="form-group">
                        <label for="apartamento">Selecciona un Apartamento:</label>
                        <select name="apartment_id" class="form-control" required>
                            <option value="">Selecciona un apartamento...</option>
                            @foreach ($apartamentos as $apartamento)
                                <option value="{{ $apartamento->id }}">{{ $apartamento->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Seleccionar le/los concepto/s que incluye la factura --}}
                    <div class="form-group">
                        <label for="conceptos">Selecciona el/los conceptos:</label>
                        <select name="conceptos[]" id="conceptos" class="form-control" multiple size="10">
                            @foreach ($conceptos as $concepto)
                                <option value="{{ $concepto->id }}">{{ $concepto->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Información adicional a la factura --}}
                    <div class="form-group">
                        <label for="notas">Nota adicional</label>
                        <input type="text" name="notas" id="notas" step="any" placeholder="Notas adicionales">
                        @error('notas')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                {{-- Botones de acción --}}
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Grabar</button>
                    <a href="{{ route('admin.facturas.index') }}" class="btn btn-secondary">Volver</a>
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

@stop
