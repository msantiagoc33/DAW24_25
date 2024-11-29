@extends('adminlte::page')

@section('title', 'Reserva-Mostrar')

@section('content_header')
@stop

@section('content')
    @can('Consultor')
        <div class="card">
            <div class="card-header">
                <h1>Ficha de reserva en <strong class="ml-2 text-primary">{{ $booking->apartment->name }}</strong></h1>
                <h2>Grabado por <strong class="ml-2 text-success">{{ $booking->user->name }}</strong></h2>
            </div>


            <div class="card-body">
                {{-- Nombre del cliente, plataforma y apartamento --}}
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Cliente</label>
                            <input value="{{ $booking->client->name }}" class="form-control custom-input" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="">Teléfono</label>
                            <input value="{{ $booking->client->phone }}" class="form-control custom-input" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="">Pais</label>
                            <input value="{{ $booking->client->pais->nombre }}" class="form-control custom-input" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="">Plataforma</label>
                            <input value="{{ $booking->platform->name }}" class="form-control custom-input" readonly>
                        </div>

                    </div>
                </div>

                {{-- Fechas de entrada, salida y días alquilado --}}
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Fecha de entrada</label>
                            <input value="{{ \Carbon\Carbon::parse($booking->fechaEntrada)->format('d-m-Y') }}"
                                class="form-control custom-input" readonly>
                        </div>

                        <div class="col-md-4">
                            <label for="">Fecha de salida</label>
                            <input value="{{ \Carbon\Carbon::parse($booking->fechaSalida)->format('d-m-Y') }}"
                                class="form-control custom-input" readonly>
                        </div>

                        {{-- Calculo del número de días alquilados --}}
                        @php
                            $diasDentro = $booking->fechaEntrada->diffInDays($booking->fechaSalida, false);
                        @endphp
                        <div class="col-md-4">
                            <label for="">Días alquilados</label>
                            <input type="text" value="{{ $diasDentro }}" id="diasAlquilado"
                                class="form-control custom-input read-only fs-18" readonly>
                        </div>
                    </div>
                </div>

                {{-- Número de huéspedes, importe y comentario --}}
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="Número de huéspedes">Número de huéspedes</label>
                            <input class="form-control custom-input" value="{{ $booking->huespedes }}" readonly>
                        </div>

                        <div class="col-md-3">
                            <label for="importe">Importe</label>
                            <input class="form-control custom-input" value="{{ $booking->importe }}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label for="comentario">Comentarios</label>
                            <input class="form-control custom-input" value="{{ $booking->comentario }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                @if ($booking->historico == 0)
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary btn-sm">Volver</a>
                @else
                    <a href="{{ route('admin.bookings.historico') }}" class="btn btn-secondary btn-sm">Volver al histórico</a>
                @endif
            </div>
        </div>
    @endcan
@stop

@section('css')

@stop

@section('js')

@stop
