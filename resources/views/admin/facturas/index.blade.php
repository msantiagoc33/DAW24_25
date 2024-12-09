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
    {{-- Bootstrap --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}

    {{-- DataTables  --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.min.css"> --}}
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

    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script>

    {{-- Bootstrap --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script> --}}

    {{-- jquery  --}}
    {{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> --}}

    {{-- DataTables  --}}
    <script>
        let dataTable;
        let dataTableInitialized = false;

        const initDataTable = async () => {
            if (dataTableInitialized) {
                dataTable.destroy();
            }

            // Inicializar el DataTable
            dataTable = $('#facturas').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.11.5/i18n/es_es.json"
                },
                "columnDefs": [{
                        orderable: false,
                        targets: [0, 4, 5, 6, 7]
                    } // Desactiva la ordenación en las columnas 0 y 3
                ],
                "order": [
                    [0, "desc"]
                ],
                "pageLength": 10,
                "lengthMenu": [10, 25, 50, 100],
                "responsive": true,
                "autoWidth": false,
            });

            dataTableInitialized = true;
        };

        window.addEventListener('load', async () => {
            await initDataTable();
        });
    </script>

@stop
