@extends('adminlte::page')
{{-- Vista para la edición de una reserva --}}

@section('title', 'Reserva-Editar')

@section('content_header')
@stop

@section('content')
    {{-- La edición de la reserva sólo estará accesible a los usuarios con rol Administrador --}}
    @if (auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Editor'))
        <br>
        {{-- Muestra los posibles mensajes --}}
        <div class="erroresMensajes">
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

        <div class="card-header bg-azul-claro text-center text-white fs-1">
            Modificar reserva
        </div>
        
        {{-- Formulario para la edición de la reserva --}}
        <div class="card">
            <form method="POST" action="{{ route('admin.bookings.update', $booking->id) }}">
                @csrf
                @method('PUT')

                <div class="card-body">
                    {{-- Nombre del cliente, plataforma y apartamento --}}
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <select id="client-select" name="client_id" class="form-control custom-input" required>
                                    <option value="">Selecciona un cliente...</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}"
                                            {{ $cliente->id == $booking->client_id ? 'selected' : '' }}>
                                            {{ $cliente->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="platform_id" class="form-control custom-input" required>
                                    <option value="">Selecciona la plataforma...</option>
                                    @foreach ($plataformas as $plataforma)
                                        <option value="{{ $plataforma->id }}"
                                            {{ $plataforma->id == $booking->platform_id ? 'selected' : '' }}>
                                            {{ $plataforma->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="apartment_id" class="form-control custom-input" required>
                                    <option value="">Selecciona el apartamento...</option>
                                    @foreach ($apartamentos as $apartamento)
                                        <option value="{{ $apartamento->id }}"
                                            {{ $apartamento->id == $booking->apartment_id ? 'selected' : '' }}>
                                            {{ $apartamento->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Fechas de entrada y salida --}}
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="fechaEntrada">Fecha de entrada</label>
                                <input type="date" name="fechaEntrada" id="fechaEntrada" class="form-control custom-input"
                                    value="{{ old('fechaEntrada', isset($booking) ? $booking->fechaEntrada->format('Y-m-d') : '') }}"
                                    required>

                                @error('fechaEntrada')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="fechaSalida">Fecha de salida</label>
                                <input type="date" name="fechaSalida" id="fechaSalida" class="form-control custom-input"
                                    value="{{ old('fechaSalida', isset($booking) ? $booking->fechaSalida->format('Y-m-d') : '') }}"
                                    required>
                                @error('fechaSalida')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="diasAlquilados">Días alquilado</label>
                                <input type="text" id="diasAlquilado" class="form-control custom-input read-only fs-18"
                                    readonly>
                            </div>
                        </div>
                    </div>

                    {{-- Número de huéspedes, importe y comentario --}}
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="Número de huéspedes">Número de huéspedes</label>
                                <input type="number" name="huespedes" id="huespedes" class="form-control custom-input"
                                    value="{{ old('huespedes', $booking->huespedes ?? '') }}" required>
                                @error('huespedes')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="importe">Importe</label>
                                <input type="number" step="0.01" name="importe" id="importe"
                                    class="form-control custom-input" value="{{ old('importe', $booking->importe ?? '') }}"
                                    required>
                                @error('importe')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="comentario">Comentarios</label>
                                <input type="text" name="comentario" id="comentario" class="form-control custom-input"
                                    value="{{ old('comentario', $booking->comentario ?? '') }}">
                                @error('comentario')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Botones de actualización de la reserva y listado de reservas --}}
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Volver</a>
                </div>

            </form>
        </div>
    @else
        {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
        @include('admin.index')
    @endif
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
    {{-- Comprueba la coherencia entre la fecha introducidas y calcula el número de días alquilado --}}
    <script>
        // Calculo del número de días alquilado
        document.addEventListener('DOMContentLoaded', function() {
            const fechaEntrada = document.getElementById('fechaEntrada');
            const fechaSalida = document.getElementById('fechaSalida');
            const diasAlquilado = document.getElementById('diasAlquilado');
            // console.log(salida, entrada);

            function calcularDias() {
                const entrada = new Date(fechaEntrada.value);
                const salida = new Date(fechaSalida.value);

                if (salida > entrada) {
                    const diffTime = Math.abs(salida - entrada); // Diferencia en milisegundos
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); // Diferencia en días
                    diasAlquilado.value = diffDays;
                } else {
                    diasAlquilado.value =
                        'El día de salida tiene que ser mayor que el de entrada'; // Limpiar si no es válido
                }

            }

            // Ejecuta al cargar la página
            calcularDias();

            // Evento para recalcular cuando cambien las fechas
            fechaEntrada.addEventListener('change', calcularDias);
            fechaSalida.addEventListener('change', calcularDias);
        });
    </script>
@stop
