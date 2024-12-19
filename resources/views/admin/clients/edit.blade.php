@extends('adminlte::page')
{{-- Vista para editar un cliente --}}
@section('title', 'Clientes|Crear')

@section('content_header')
@stop

@section('content')
    {{-- Sólo tendrán acceso a la edición de cliente los usuarios con el rol Administrador --}}
    @can('Administrador')
        <br>
        {{-- Se visualizan los posibles mensajes --}}
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
                Modificar cliente
            </div>

            <form method="POST" action="{{ route('admin.clients.update', $client->id) }}">
                @csrf
                @method('PUT')

                <div class="card-body">
                    {{-- Nombre, pais --}}
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
                    {{-- Teléfono, DNI o pasaporte --}}
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
                    {{-- Dirección y localidad --}}
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
                    {{-- Provincia y CP --}}
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
                {{-- botones de acción --}}
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">Volver</a>
                </div>
            </form>
        </div>
    @else
        {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
        @include('admin.index')
    @endcan
@stop

@section('css')
    {{-- El campo  que tiene el foco se le cambio el color de fondo --}}
    <style>
        .custom-input:focus {
            background-color: #cce5ff;
            outline: none;
        }
    </style>
@stop

@section('js')
    {{-- Pone en mayúsculas la primera letra de los que escribamos en los inputs --}}
    <script>
        function capitalizeFirstLetter(input) {
            input.value = input.value.charAt(0).toUpperCase() + input.value.slice(1);
        }
    </script>
@stop
