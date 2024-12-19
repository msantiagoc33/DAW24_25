@extends('adminlte::page')

@section('title', 'Reservas-index')

@section('content_header')

    <br>
    @can('Consultor')
        {{-- Carga el componente bookings-index --}}
        @livewire('admin.bookings-index')
    @else
        {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
        @include('admin.index')
    @endcan
@stop

@section('css')

@stop

@section('js')
    {{-- Script que muestra la fecha y la hora actual actualizándose cada segundo --}}
    <script>
        function updateClock() {
            const now = new Date();
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            };
            document.getElementById('clock').innerHTML = now.toLocaleString('es-ES', options);
        }

        // Actualiza la hora inmediatamente al cargar la página
        updateClock();

        // Actualiza la hora cada segundo
        setInterval(updateClock, 1000);
    </script>
@stop
