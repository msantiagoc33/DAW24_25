@extends('adminlte::page')

{{-- Vista que muestra el calendario con las reservas --}}
@section('title', 'Calendario')

@section('content_header')

@stop

@section('content')
    <br>
    {{-- Podrá ver el calendario los usuarios con el rol de Consultor --}}
    @if (auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Editor')|| auth()->user()->hasRole('Consultor'))
        {{-- Aquí se generará el calendario --}}
        <div class="container">
            <div id="calendar"></div>
        </div>
    @else
        {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
        @include('admin.index')
    @endif

@stop

@section('css')

@stop

@section('js')
    {{-- Este script genera el calendario y los muestra el el div con id igual a calendar --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Contenedor del calendario 
            var calendarEl = document.getElementById('calendar');

            // Fechas reservadas desde PHP
            var fechasReservadas = @json($fechasReservadas); // Convertir a JSON

            // Inicializar el calendario
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'multiMonthYear', // Se ve todo el año
                // initialView: 'dayGridMonth', // Se ve sólo un mes
                events: fechasReservadas,
                eventColor: 'color-azul-claro', // Color de las reservas
                eventTextColor: '#ffffff',
            });

            calendar.render();
        });
    </script>
@stop
