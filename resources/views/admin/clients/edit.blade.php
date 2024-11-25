@extends('adminlte::page')

@section('title', 'Clientes|Crear')

@section('content_header')


@stop

@section('content')
    @can('Administrador')
        <br>
        <div class="erroresMensaje">
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
            <div class="card-header">
                <h5>Modificar cliente</h5>
            </div>
            <form method="POST" action="{{ route('admin.clients.update', $client->id) }}">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control custom-input" placeholder="Nombre"
                                    value="{{ old('name', $client->name) }}" required autofocus
                                    oninput="this.value = this.value.toUpperCase()">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <select name="country_id" class="form-control custom-input" required>
                                    <option value="">Selecciona un País...</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ $country->id == $client->country_id ? 'selected' : '' }}>
                                            {{ $country->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-phone text-primary"></i>
                                    </span>
                                    <input type="text" name="phone" class="form-control custom-input"
                                        placeholder="Teléfono" value="{{ old('phone', $client->phone) }}" required>
                                </div>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-passport text-primary"></i>
                                    </span>
                                    <input type="text" name="passport" class="form-control custom-input"
                                        placeholder="DNI o Pasaporte" value="{{ old('passport', $client->passport) }}"
                                        required>
                                </div>
                                @error('passport')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="calle_numero" class="form-control custom-input"
                                    placeholder="Calle y número" value="{{ old('calle_numero', $client->calle_numero) }}"
                                    required>
                                @error('calle_numero')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="ciudad" class="form-control custom-input" placeholder="Ciudad"
                                    value="{{ old('ciudad', $client->ciudad) }}" required
                                    oninput="capitalizeFirstLetter(this)">
                                @error('ciudad')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="provincia" class="form-control custom-input"
                                    placeholder="Pronvincia" value="{{ old('provincia', $client->provincia) }}" required
                                    oninput="capitalizeFirstLetter(this)">
                                @error('provincia')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="cp" class="form-control custom-input"
                                    placeholder="Código Postal" value="{{ old('cp', $client->cp) }}" required>
                                @error('cp')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">Volver</a>
                </div>
            </form>
        </div>
    @else
        @php
            $nombre = auth()->user()->name; // Obtener el nombre del usuario
            $corto = strstr($nombre, ' ', true); // Obtener la parte antes del primer espacio
        @endphp
        <p>Bienvenido {{ $corto }}</p> <!-- Imprimir el valor de $corto correctamente -->
    @endcan
@stop

@section('css')
    <style>
        .custom-input:focus {
            background-color: #cce5ff;
            outline: none;
        }
    </style>
@stop

@section('js')
    <script>
        function capitalizeFirstLetter(input) {
            input.value = input.value.charAt(0).toUpperCase() + input.value.slice(1);
        }
    </script>
@stop
