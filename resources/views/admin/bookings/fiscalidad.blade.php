@extends('adminlte::page')

@section('title', 'Reservas-index')

@section('content_header')
    <br>
    @can('Consultor')
        @livewire('admin.fiscalidad')
    @else
        @include('admin.index')
    @endcan
@stop

@section('css')

@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const year = document.getElementById('year');
            const apartamento = document.getElementById('apartment_id');

            // Enfocar al primer campo (año) al cargar la página
            year.focus();

            year.addEventListener('input', function() {
                const currentYear = new Date().getFullYear();
                const value = parseInt(yearInput.value, 10);

                if (value < 2000 || value > currentYear) {
                    yearInput.setCustomValidity(`El año debe estar entre 2000 y ${currentYear}.`);
                } else {
                    yearInput.setCustomValidity(''); // Restablecer el estado válido
                }
            });
        });
    </script>
@stop
