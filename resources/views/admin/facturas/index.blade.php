@extends('adminlte::page')

@section('title', 'Factura-edit')

@section('content_header')

@stop

@section('content')
    <br>
    @if (auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Editor') || auth()->user()->hasRole('Consultor'))
        <div class="container">
            @livewire('admin.facturas-index')
        </div>
    @else
        {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
        @include('admin.index')
    @endif

@stop

@section('css')
    <style>
        /* Estilo inicial (oculto) del formulario de búsqueda de facturas */
        .hidden {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease-out;
        }

        /* Estilo desplegado del formulario de búsqueda de facturas */
        .visible {
            max-height: 500px;
        }
    </style>
@stop

@section('js')
    <script>
        // Mostrar alerta de confirmación antes de eliminar un registro
        function confirmDelete(facturaId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, enviar el formulario
                    document.getElementById('delete-form-' + facturaId).submit();
                }
            });
        }

        // Oculta/Muestra el formulario de búsqueda
        document.getElementById('toggleForm').addEventListener('click', function() {
            const form = document.getElementById('hiddenForm');
            form.classList.toggle('visible'); // Alterna entre las clases "hidden" y "visible"
        });
    </script>

@stop
