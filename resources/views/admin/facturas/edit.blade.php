@extends('adminlte::page')

@section('title', 'Admin-edit-Factura')

@section('content_header')

@stop

@section('content')

    @can('Administrador')
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
        </div>

        <div class="card">
            <div class="card-header bg-gray-400">
                <h5>Modificar factura.</h5>
            </div>

            <form action="{{ route('admin.facturas.update', $factura->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group">
                        <label for="fecha">Fecha de la factura</label>
                        <input type="date" name="fecha" id="fecha" class="form-control"
                            placeholder="Fecha de la facturas" value="{{ old('number', $factura->fecha) }}" required>
                        @error('fecha')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="importe">Importe</label>
                        <input type="number" name="importe" id="importe" step="any" placeholder="Ejemplo: 125.36"
                            value="{{ old('number', $factura->importe) }}" required>
                        @error('importe')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

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

                    <div class="form-group">
                        <label for="conceptos">Conceptos</label>
                        <select name="conceptos[]" id="conceptos" class="form-control" multiple>
                            @foreach ($conceptos as $concepto)
                                <option value="{{ $concepto->id }}"
                                    {{ in_array($concepto->id, $factura->concepts->pluck('id')->toArray()) ? 'selected' : '' }}>
                                    {{ $concepto->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="notas">Nota adicional</label>
                        <input type="text" name="notas" id="notas" step="any" placeholder="Notas adicionales"
                            value="{{ old('number', $factura->notas) }}">
                        @error('notas')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="card-footer float-right">
                        <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                        <a href="{{ route('admin.facturas.index') }}" class="btn btn-secondary btn-sm">Volver</a>
                    </div>
                </div>
            </form>
        </div>
    @endcan
@stop

@section('css')

@stop

@section('js')
    <script></script>
@stop
