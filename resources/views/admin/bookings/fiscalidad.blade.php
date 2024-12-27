@extends('adminlte::page')

@section('title', 'Fiscalidad')

@section('content_header')
    <br>
    @if (auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Editor') || auth()->user()->hasRole('Consultor'))
        {{-- Carga el componente fiscalidad --}}
        @livewire('admin.fiscalidad')
    @else
        {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
        @include('admin.index')
    @endif
@stop

@section('css')

@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const year = document.getElementById('year');
            const apartamento = document.getElementById('apartment_id');

            // Enfocar al primer campo (apartamento) al cargar la página
            apartamento.focus();

            // Asegura que el año introducido está entre el año 2000 y el año actual.
            year.addEventListener('input', function() {
                const currentYear = new Date().getFullYear(); // Tomamos sólo el año de la fecha de hoy
                const value = parseInt(yearInput.value, 10);  // El valor lo ponemos en base 10

                // Si el año es menor que el año 200 o mayor que le año actual, muestra el mensaje.
                if (value < 2000 || value > currentYear) {
                    yearInput.setCustomValidity(`El año debe estar entre 2000 y ${currentYear}.`);
                } else {
                    // Borro el mensaje
                    yearInput.setCustomValidity(''); // Restablecer el estado válido
                }
            });
        });
    </script>
@stop
