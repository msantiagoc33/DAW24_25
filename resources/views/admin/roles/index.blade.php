@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')

@stop

@section('content')
    <br>
    @can('Administrador')
        @if (session('info'))
            <div class="alert alert-success">
                <strong>{{ session('info') }}</strong>
            </div>
        @endif
    @endcan
    @can('Administrador')
        @if ($roles->count())
            <div class="card">
                <div class="card-header">
                    <div class="card-header bg-azul-claro text-center text-white fs-1">
                        Lista de Roles
                    </div>                   
                </div>
                
                <div class="card-body">
                    @can('Administrador')
                        <a class="btn btn-info btn-sm float-left mb-3" href="{{ route('roles.create') }}">Nuevo</a>
                    @endcan
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th class="text-center">Nombre</th>
                            <th class="text-center" colspan="3">Acciones</th>
                        </tr>
                        @foreach ($roles as $rol)
                            <tr>
                                <td>{{ $rol->name }}</td>

                                @can('Administrador')
                                    <td class="text-center" width='10px'>
                                        <a href="{{ route('roles.edit', $rol) }}"><i class="fas fa-fw fa-regular fa-pen"></i></a>
                                    </td>

                                    <td class="text-center" width='10px'>
                                        <form action="{{ route('roles.destroy', $rol) }}" method="POST" style="display:inline;"
                                            id="delete-form-{{ $rol->id }}">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" onclick="confirmDelete({{ $rol->id }})"
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
    @else
        @include('admin.index');
    @endcan

@stop

@section('css')

@stop

@section('js')
    <script>
        function confirmDelete(rolId) {
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
                    document.getElementById('delete-form-' + rolId).submit();
                }
            });
        }
    </script>
@stop
