@extends('adminlte::page')

{{-- Vista de todas las plataformas --}}
@section('title', 'Platforms-index')

@section('content_header')

@stop

@section('content')
    {{-- Los usuarios con el rol de Consultor podrán ver esta vista --}}
    @if (auth()->user()->hasRole('Administrador') ||
            auth()->user()->hasRole('Editor') ||
            auth()->user()->hasRole('Consultor') ||
            auth()->user()->hasRole('Invitado'))
        <br>
        {{-- Comprueba si hay plataformas que mostrar --}}
        @if ($platforms->count())
            <div class="card">
                <div class="card-header">
                    <div class="card-header bg-azul-claro text-center text-gris-claro fs-1">
                        Lista de Plataforms
                    </div>

                </div>
                <div class="card-body">
                    @can('Administrador')
                        <a class="btn btn-info btn-sm float-left mb-3" href="{{ route('admin.platforms.create') }}">Nuevo</a>
                    @endcan
                    <br>
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th class="text-center">Nombre</th>
                            @if (auth()->user()->hasRole('Administrador'))
                                <th class="text-center" colspan="2">Acciones</th>
                            @elseif (auth()->user()->hasRole('Editor'))
                                <th class="text-center">Acción</th>
                            @endif
                        </tr>
                        @foreach ($platforms as $platform)
                            <tr>
                                <td>{{ $platform->name }}</td>

                                {{-- Si tiene el rol de Adminstrador podrá editar y/o eliminar plataformas --}}
                                @if (auth()->user()->hasRole('Administrador'))
                                    <td class="text-center" width='10px'>
                                        <a href="{{ route('admin.platforms.edit', $platform) }}"><i
                                                class="fas fa-fw fa-regular fa-pen text-amarillo-claro"></i></a>
                                    </td>

                                    <td class="text-center" width='10px'>
                                        <form action="{{ route('admin.platforms.destroy', $platform) }}" method="POST"
                                            style="display:inline;" id="delete-form-{{ $platform->id }}">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" onclick="confirmDelete({{ $platform->id }})"
                                                style="border:none; background:none; color:rgb(25, 134, 236);">
                                                <i class="fas fa-fw fa-trash text-rojo-claro"></i>
                                            </button>
                                        </form>
                                    </td>
                                @elseif (auth()->user()->hasRole('Editor'))
                                    <td class="text-center" width='10px'>
                                        <a href="{{ route('admin.platforms.edit', $platform) }}"><i
                                                class="fas fa-fw fa-regular fa-pen text-amarillo-claro"></i></a>
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
    {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
    @include('admin.index')
@endif

@stop

@section('css')
@stop

@section('js')
{{-- Script que muestra una ventana emergente para confirmación de eliminación de registro --}}
<script>
    function confirmDelete(plataformaId) {
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
                document.getElementById('delete-form-' + plataformaId).submit();
            }
        });
    }
</script>
@stop
