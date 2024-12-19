@extends('adminlte::page')

@section('title', 'Users-index')

@section('content_header')

@stop

@section('content')
    <br>
    @can('Administrador')
        @livewire('admin.users-index')
    @else
        {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
        @include('admin.index');
    @endcan
@stop

@section('css')
@stop

@section('js')
<script>
    function confirmDelete(userId) {
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
                document.getElementById('delete-form-' + userId).submit();
            }
        });
    }
</script>
@stop
