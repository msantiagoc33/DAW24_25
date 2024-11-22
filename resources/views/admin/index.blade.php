@extends('adminlte::page')

@section('title', 'Admin-index')

@section('content_header')

    <h1>Aplicación de SANGUT apartments</h1>
@stop

@section('content')
    <br>
    <div class="card">
        <div class="card-body">
            <div id="clock"></div>
        </div>
    </div>
@stop

@section('css')
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }

        #clock {
            font-size: 2em;
            margin: 20px;
        }
    </style>
@stop

@section('js')
{{-- Muestra la fecha y la hora en el div clock --}}
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
        // Luego, actualiza cada segundo
        setInterval(updateClock, 1000);
    </script>
@stop
