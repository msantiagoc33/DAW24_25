@extends('adminlte::page')

@section('title', 'Reservas-index')

@section('content_header')
    <br>
    @if (auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Editor')|| auth()->user()->hasRole('Consultor'))
        {{-- Carga el componente bookings-index --}}
        @livewire('admin.bookings-index')
    @else
        {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
        @include('admin.index')
    @endif
@stop

@section('css')

@stop

@section('js')
       {{-- Script que muestra una ventana modal para confirmar eliminación de registro --}}
       <script>
        function confirmDelete(clienteId) {
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
                    document.getElementById('delete-form-' + clienteId).submit();
                }
            });
        }
    </script> 
@stop
