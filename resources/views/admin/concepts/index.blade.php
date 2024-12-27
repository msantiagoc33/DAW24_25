@extends('adminlte::page')

@section('title', 'Conceptos-index')

@section('content_header')

@stop

@section('content')
    <br>
    @if (auth()->user()->hasRole('Administrador') ||
            auth()->user()->hasRole('Editor') ||
            auth()->user()->hasRole('Consultor'))
        {{-- Mostrar el componente de Livewire --}}
        @livewire('admin.concepts-index')
    @else
        {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
        @include('admin.index');
    @endif
@stop

@section('css')
@stop

@section('js')
    {{-- Script para mostrar modal emergente de confirmación de eleminación de registro --}}
    <script>
        function confirmDelete(conceptoId) {
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
                    document.getElementById('delete-form-' + conceptoId).submit();
                }
            });
        }
    </script>
@stop
