@extends('adminlte::page')
{{-- Vista que muestra los apartamentos gestionados --}}
@section('title', 'Apartments-index')

@section('content_header')
    {{-- Cabecera de la página (opcional, vacía en este caso). --}}
@stop

@section('content')
    <div class="container">
        {{-- Sección para mostrar errores y mensajes de éxito --}}
        <div class="erroresMensajes">
            @if ($errors->any())
                {{-- Lista de errores de validación --}}
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('info'))
                {{-- Mensaje de información --}}
                <div class="alert alert-success">
                    <strong>{{ session('info') }}</strong>
                </div>
            @endif

            @if (session('success'))
                {{-- Mensaje de éxito --}}
                <div class="alert alert-success">
                    <strong>{{ session('success') }}</strong>
                </div>
            @endif
        </div>
        <br>
        {{-- Verificación de permisos del usuario --}}
        @if (auth()->user()->hasRole('Administrador') ||
                auth()->user()->hasRole('Editor') ||
                auth()->user()->hasRole('Consultor') ||
                auth()->user()->hasRole('Invitado'))
            @if ($apartments->count())
                {{-- Tabla que muestra la lista de apartamentos si existen registros --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-header bg-azul-claro text-center text-gris-claro fs-1">
                            Lista de Apartamentos
                        </div>

                    </div>
                    <div class="card-body">
                        {{-- Botón para crear un nuevo apartamento (solo visible para administradores) --}}
                        @can('Administrador')
                            <a class="btn btn-info btn-sm float-left mb-3"
                                href="{{ route('admin.apartments.create') }}">Nuevo</a>
                        @endcan
                        <br>
                        {{-- Tabla que muestra la lista de apartamentos --}}
                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <tr>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Dirección</th>
                                    <th class="text-center">Descripción</th>
                                    <th class="text-center">Habitaciones</th>
                                    <th class="text-center">Huéspedes</th>
                                    @if (auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Editor'))
                                        <th class="text-center" colspan="3">Acciones</th>
                                    @elseif (auth()->user()->hasRole('Consultor'))
                                        <th class="text-center" colspan="2">Acciones</th>
                                    @endif
                                </tr>
                                @foreach ($apartments as $apartment)
                                    <tr>
                                        <td>{{ $apartment->name }}</td>
                                        <td>{{ $apartment->address }}</td>
                                        <td>{{ $apartment->description }}</td>
                                        <td class="text-center">{{ $apartment->rooms }}</td>
                                        <td class="text-center">{{ $apartment->capacidad }}</td>
                                        @if (auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Editor'))
                                            <td class="text-center" width='10px'>
                                                <a href="{{ route('admin.apartments.show', $apartment) }}"><i
                                                        class="fas fa-fw fa-regular fa-eye text-verde-claro"></i></a>
                                            </td>
                                        @endif

                                        {{-- Botones de edición y borrado de apartamento solo disponible para usuarios con el rol de Administrador --}}
                                        @if (auth()->user()->hasRole('Administrador'))
                                            <td class="text-center" width='10px'>
                                                <a href="{{ route('admin.apartments.edit', $apartment) }}"><i
                                                        class="fas fa-fw fa-regular fa-pen text-amarillo-claro"></i></a>
                                            </td>

                                            <td class="text-center" width='10px'>
                                                <form action="{{ route('admin.apartments.destroy', $apartment) }}"
                                                    method="POST" style="display:inline;"
                                                    id="delete-form-{{ $apartment->id }}">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="button" onclick="confirmDelete({{ $apartment->id }})"
                                                        style="border:none; background:none; color:rgb(25, 134, 236);">
                                                        <i class="fas fa-fw fa-trash text-rojo-claro"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        @elseif (auth()->user()->hasRole('Consultor'))
                                            <td class="text-center" width='10px'>
                                                <a href="{{ route('admin.apartments.edit', $apartment) }}"><i
                                                        class="fas fa-fw fa-regular fa-pen text-amarillo-claro"></i></a>
                                        @endif
                                    </tr>
                                @endforeach

                            </table>
                        </div>
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
    </div>
@stop

@section('css')

@stop

@section('js')
    {{-- Función que muestra una pantalla modal para confirmar el borrado del registro seleccionado --}}
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
