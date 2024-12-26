@extends('adminlte::page')
{{-- Vista para la creación de una reserva --}}
@section('title', 'Reserva-crear')

@section('content_header')
@stop

@section('content')
    {{-- La vista del formulario de creación de reserva sólo esta disponible para el rol Administrador --}}
    @can('Administrador')
        <br>
        {{-- Muestra los posibles mensajes --}}
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
            <div class="card-header bg-azul-claro">
                <h1><strong class="text-white">Dar de alta una nueva reserva</strong></h1>
            </div>

            <form method="POST" action="{{ route('admin.bookings.store') }}" id="formularioReserva">
                @csrf

                <div class="card-body">
                    {{-- Nombre del cliente, plataforma y apartamento --}}
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <select id="client-select" name="client_id" class="form-control custom-input" required>
                                    <option value="">Selecciona un cliente...</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}" data-pais='{{ $cliente->pais->nombre }}'
                                            data-telefono='{{ $cliente->phone }}'>{{ $cliente->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1 d-flex justify-content-left align-items-left">
                                {{-- Añadimos el parámetro origin para enviarlo con la ruta 
                                para saber quién llamo a la ruta y poder volver al origen --}}
                                <a class="btn btn-info btn-md"
                                    href="{{ route('admin.clients.create', ['origin' => 'reservas']) }}">Nuevo</a>
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
                                <h5 id="errorFechaEntrada" class="text-danger"></h5>
                                @error('fechaEntrada')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="diasAlquilados">Fecha de salida</label>
                                <input type="date" name="fechaSalida" id="fechaSalida" class="form-control custom-input"
                                    placeholder="Fecha de salida" value="{{ old('fechaSalida') }}" required>
                                <h5 id="errorFechaSalida" class="text-danger"></h5>
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
                                    placeholder="Número de huéspedes" value="{{ old('huespedes') }}" required>
                                @error('huespedes')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="importe">Importe</label>
                                <input type="number" step="0.01" name="importe" id="importe"
                                    class="form-control custom-input" placeholder="Importe" value="{{ old('importe') }}"
                                    required>
                                @error('importe')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="comentario">Comentarios</label>
                                <input type="text" name="comentario" id="comentario" class="form-control custom-input"
                                    placeholder="Comentarios" value="{{ old('comentario') }}">
                                @error('comentario')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Botones de grabación y listado de todas las reservas --}}
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Grabar</button>                   
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Volver</a>
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
    {{-- Comprueba la coherencia con la fechas y calcula el número de días alquilado --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const clientSelect = document.getElementById('client-select');
            const fechaEntrada = document.getElementById('fechaEntrada');
            const fechaSalida = document.getElementById('fechaSalida');
            const diasAlquilado = document.getElementById('diasAlquilado');
            const errorFechaEntrada = document.getElementById('errorFechaEntrada');
            const errorFechaSalida = document.getElementById('errorFechaSalida');

            // Desactivar diasAlquilado y fechaSalida al principio
            diasAlquilado.disabled = true;
            fechaSalida.disabled = true;

            // Enfocar al primer campo (cliente) al cargar la página
            if (clientSelect) clientSelect.focus();

            // Cuando haya un cambio en la fecha de entrada
            fechaEntrada.addEventListener('change', function() {
                // asignamos a la variable entrada la fecha de entrada
                const entrada = new Date(fechaEntrada.value);
                // asignamos a la variable hoy la fecha de hoy
                const hoy = new Date();

                // Restablecer valores iniciales
                errorFechaEntrada.innerText = '';
                // habilitar el campo de fecha de salida una vez que hemos relleando la fecha de entrada
                fechaSalida.disabled = true;

                // Ajustar las horas de las fechas para que no haya diferencias al comparar las fechas
                hoy.setHours(0, 0, 0, 0);
                entrada.setHours(0, 0, 0, 0);

                // La fecha de entrada no puede ser menor que la fecha de hoy
                if (entrada < hoy) {
                    errorFechaEntrada.innerText =
                        'La fecha de entrada no puede ser menor que la fecha de hoy.';
                    fechaEntrada.focus();
                    return;
                }

                // Habilitar fecha de salida una vez comprobado que la fecha de entrada es correcta
                fechaSalida.disabled = false;

                // No se podrá seleccionar una fecha en el campo fechaSalida que sea anterior a la fecha seleccionada en el campo fechaEntrada.
                fechaSalida.min = fechaEntrada.value;

                // Sugerir un valor por defecto para la fecha de salida (2 día después)
                const salidaDefault = new Date(entrada);
                salidaDefault.setDate(salidaDefault.getDate() + 2);
                fechaSalida.value = salidaDefault.toISOString().split('T')[0];
            });

            // Calcular los días alquilados
            fechaSalida.addEventListener('change', function() {
                const entrada = new Date(fechaEntrada.value);
                const salida = new Date(fechaSalida.value);

                // Limpiar errores previos
                errorFechaSalida.innerText = '';

                // Verificar si la fecha de salida es válida
                if (salida <= entrada) {
                    errorFechaSalida.innerText =
                        'La fecha de salida debe ser mayor que la de entrada.';
                    fechaSalida.focus();
                    diasAlquilado.value = '';
                    return;
                }

                // Calcular la diferencia en días
                const diffTime = Math.abs(salida - entrada); // Diferencia en milisegundos
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); // Diferencia en días
                diasAlquilado.value = diffDays + 1;
            });
        });
    </script>

@stop
