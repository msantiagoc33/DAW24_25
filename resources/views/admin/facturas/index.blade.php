@extends('adminlte::page')

@section('title', 'Admin-index')

@section('content_header')

@stop

@section('content')
    <br>
    @can('Consultor')
        @livewire('admin.facturas-index')
    @else
        @include('admin.index')
    @endcan

@stop

@section('css')
    
@stop

@section('js')
    

    <script>
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
