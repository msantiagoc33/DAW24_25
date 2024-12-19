@extends('adminlte::page')
{{-- Vista de la edición de una factura --}}
@section('title', 'Admin-edit-Factura')

@section('content_header')

@stop

@section('content')
    {{-- Sólo tendrán acceso a la edición de facturas los usuarios con el rol de Administrador --}}
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

            <!-- Mostrar el mensaje de error -->
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <div class="card">
            <div class="card-header bg-azul-claro text-center text-white fs-1">
                Modificar factura
            </div>

            <form action="{{ route('admin.facturas.update', $factura->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                {{-- Fecha de la factura --}}
                <div class="card-body">
                    <div class="form-group">
                        <label for="fecha">Fecha de la factura</label>
                        <input type="date" name="fecha" id="fecha" class="form-control"
                            placeholder="Fecha de la facturas" value="{{ old('number', $factura->fecha) }}" required>
                        @error('fecha')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Importe de la factura --}}
                    <div class="form-group">
                        <label for="importe">Importe</label>
                        <input type="number" name="importe" id="importe" step="any" placeholder="Ejemplo: 125.36"
                            value="{{ old('number', $factura->importe) }}" required>
                        @error('importe')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nombre de la factura actual y selección para subir factura --}}
                    <div class="form-group">
                        <label for="">Factura actual</label>
                        @if ($factura->file_uri)
                            <a href="{{ asset('storage/' . $factura->file_uri) }}" target="_blank">Ver factura</a>
                        @else
                            <p>No hay factura cargada.</p>
                        @endif

                        <label for="file_uri">Subir nueva factura (opcional)</label>
                        <input type="file" name="file_uri" id="file_uri" class="form-control">

                        @error('file_uri')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Seleccionar el apartamento al que se le asigna la factura --}}
                    <div class="form-group">
                        <label for="apartment_id">Apartamento</label>
                        <select name="apartment_id" id="apartment_id" class="form-control">
                            @foreach ($apartamentos as $apartamento)
                                <option value="{{ $apartamento->id }}"
                                    {{ $apartamento->id == $factura->apartamento_id ? 'selected' : '' }}>
                                    {{ $apartamento->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Seleccionar el/los conceptos de la factura --}}
                    <div class="form-group">
                        <label for="conceptos">Conceptos</label>
                        <select name="conceptos[]" id="conceptos" class="form-control" multiple size="10">
                            @foreach ($conceptos as $concepto)
                                <option value="{{ $concepto->id }}"
                                    {{ in_array($concepto->id, $factura->concepts->pluck('id')->toArray()) ? 'selected' : '' }}>
                                    {{ $concepto->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Nota adicional a la factura --}}
                    <div class="form-group">
                        <label for="notas">Nota adicional</label>
                        <input type="text" name="notas" id="notas" step="any" placeholder="Notas adicionales"
                            value="{{ old('number', $factura->notas) }}">
                        @error('notas')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Botones de acción --}}
                    <div class="card-footer float-right">
                        <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                        <a href="{{ route('admin.facturas.index') }}" class="btn btn-secondary btn-sm">Volver</a>
                    </div>
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
