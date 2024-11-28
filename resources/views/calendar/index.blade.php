@extends('adminlte::page')

@section('title', 'Calendario')

@section('content_header')
    <style>
       
    </style>
@stop

@section('content')
    <br>
    @can('Consultor')
        <div id="calendar"></div>
    @else
        @include('admin.index')
    @endcan

@stop

@section('css')

@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Contenedor del calendario 
            var calendarEl = document.getElementById('calendar');

            // Fechas reservadas desde PHP
            var fechasReservadas = @json($fechasReservadas); // Convertir a JSON

            // Inicializar el calendario
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'multiMonthYear',
                // initialView: 'dayGridMonth',
                events: fechasReservadas,
                eventColor: 'color-azul-claro', // Color de los eventos
                eventTextColor: '#ffffff',
            });

            calendar.render();
        });
    </script>
@stop
