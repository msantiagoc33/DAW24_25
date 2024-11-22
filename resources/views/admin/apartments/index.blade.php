@extends('adminlte::page')

@section('title', 'Apartments-index')

@section('content_header')

@stop

@section('content')
    <br>
    @can('Consultor')
        @if ($apartments->count())
            <div class="card">
                <div class="card-header">
                    @can('Administrador')
                        <a class="btn btn-info btn-sm float-left mb-3" href="{{ route('admin.apartments.create') }}">Nuevo</a>
                    @endcan
                </div>
                <div class="card-body">
                    <table class="table  table-striped">
                        <tr>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Dirección</th>
                            <th class="text-center">Descripción</th>
                            <th class="text-center">Habitaciones</th>
                            <th class="text-center">Huéspedes</th>
                            <th class="text-center" colspan="3">Acciones</th>
                        </tr>
                        @foreach ($apartments as $apartment)
                            <tr>
                                <td>{{ $apartment->name }}</td>
                                <td>{{ $apartment->address }}</td>
                                <td>{{ $apartment->description }}</td>
                                <td class="text-center">{{ $apartment->rooms }}</td>
                                <td class="text-center">{{ $apartment->capacidad }}</td>

                                <td class="text-center" width='10px'>
                                    <a href="{{ route('admin.apartments.show', $apartment) }}"><i
                                            class="fas fa-fw fa-regular fa-eye"></i></a>
                                </td>

                                @can('Administrador')
                                    <td class="text-center" width='10px'>
                                        <a href="{{ route('admin.apartments.edit', $apartment) }}"><i
                                                class="fas fa-fw fa-regular fa-pen"></i></a>
                                    </td>

                                    <td class="text-center" width='10px'>
                                        <form action="{{ route('admin.apartments.destroy', $apartment) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" onclick="confirmDelete({{ $apartment->id }})"
                                                style="border:none; background:none; color:rgb(25, 134, 236);">
                                                <i class="fas fa-fw fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach

                    </table>
                </div>
            </div>
        @else
            <div class="card-body">
                <strong>No hay registros</strong>
            </div>
        @endif
    @endcan

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
<script>
    function confirmDelete(apartamentoId) {
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
                document.getElementById('delete-form-' + apartamentoId).submit();
            }
        });
    }
</script>
@stop
