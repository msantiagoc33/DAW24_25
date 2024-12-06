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
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
@stop

@section('js')
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>

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

        //  inicializa DataTables para que la tabla se convierta en una tabla interactiva
        $(document).ready(function() {
            
            $('#facturas').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json" // Traducción al español
                },
                "paging": true, // Habilita paginación
                "searching": true, // Habilita búsqueda
                "ordering": true, // Habilita ordenamiento
                "lengthChange": true, // Habilita cambio de cantidad de filas por página
                "info": true, // Muestra información sobre el total de registros
            });
            
        });
    </script>
@stop
