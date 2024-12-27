@extends('adminlte::page')

@section('title', 'Admin-index')

@section('content_header')

@stop

@section('content')
    <br>
    @if (auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Editor'))
        {{-- Mostrar la vista de clientes --}}
        @livewire('admin.clients-index')
    @else
        {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
        @include('admin.index')
    @endif

@stop

@section('css')

@stop

@section('js')
    {{-- Script para mostrar una ventana modal de confirmación de eliminación de registro --}}
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
