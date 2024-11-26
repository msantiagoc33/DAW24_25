@extends('adminlte::page')

@section('title', 'Reserva-crear')

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
                <h5>Dar de alta una nueva reserva</h5>
            </div>

            <form method="POST" action="{{ route('admin.bookings.store') }}">
                @csrf
                
                <div class="card-body">
                    {{-- Nombre del cliente, plataforma y apartamento --}}
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <select id="client-select" name="client_id" class="form-control custom-input" required>
                                    <option value="">Selecciona un cliente...</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}" data-pais='{{ $cliente->pais->nombre }}'
                                            data-telefono='{{ $cliente->phone }}'>{{ $cliente->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="platform_id" class="form-control custom-input" required>
                                    <option value="">Selecciona la plataforma...</option>
                                    @foreach ($plataformas as $plataforma)
                                        <option value="{{ $plataforma->id }}">{{ $plataforma->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="apartment_id" class="form-control custom-input" required>
                                    <option value="">Selecciona el apartamento...</option>
                                    @foreach ($apartamentos as $apartamento)
                                        <option value="{{ $apartamento->id }}">{{ $apartamento->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Fechas de entrada y salida --}}
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="diasAlquilados">Fecha de entrada</label>
                                <input type="date" name="fechaEntrada" id="fechaEntrada" class="form-control custom-input"
                                    placeholder="Fecha de entrada" value="{{ old('fechaEntrada') }}" required>
                                @error('fechaEntrada')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="diasAlquilados">Fecha de salida</label>
                                <input type="date" name="fechaSalida" id="fechaSalida" class="form-control custom-input"
                                    placeholder="Fecha de salida" value="{{ old('fechaSalida') }}" required>
                                @error('fechaSalida')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="diasAlquilados">Días alquilado</label>
                                <input type="text" id="diasAlquilado" class="form-control custom-input read-only fs-18" readonly>
                            </div>
                        </div>
                    </div>

                     {{-- Número de huéspedes, importe y comentario --}}
                     <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="Número de huéspedes">Número de huéspedes</label>
                                <input type="number" name="huespedes" id="huespedes" class="form-control custom-input"
                                    placeholder="Número de huéspedes" value="{{ old('huespedes') }}" required>
                                @error('huespedes')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="importe">Importe</label>
                                <input type="number" step="" name="importe" id="importe" class="form-control custom-input"
                                    placeholder="Importe" value="{{ old('importe') }}" required>
                                @error('importe')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="comentario">Comentarios</label>
                                <input type="text" name="comentario" id="comentario" class="form-control custom-input"
                                    placeholder="Comentarios" value="{{ old('comentario') }}" required>
                                @error('comentario')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Grabar</button>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Volver</a>
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
@stop

@section('js')
    <script>
        // Calculo del número de días alquilado
        document.addEventListener('DOMContentLoaded', function() {
            const fechaEntrada = document.getElementById('fechaEntrada');
            const fechaSalida = document.getElementById('fechaSalida');
            const diasAlquilado = document.getElementById('diasAlquilado');


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

            // Evento para recalcular cuando cambien las fechas
            fechaSalida.addEventListener('change', calcularDias);
        });
    </script>
@stop
