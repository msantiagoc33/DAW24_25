<div class="container">
    {{-- Vista de todos los conceptos de factura --}}
    {{-- Pueden ser vistos por los usuarios con el rol de Consultor --}}
    @if (auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Editor') || auth()->user()->hasRole('Consultor'))
        <div class="card">
            {{-- Muestra posibles mensajes --}}
            @if (session('success'))
                <div class="alert alert-success">
                    <strong>{{ session('success') }}</strong>
                </div>
            @endif

            <div class="card-header bg-azul-claro text-center text-gris-claro fs-1">
                Lista de Conceptos
            </div>

            <br>
            {{-- Campo de búsqueda de conceptos --}}
            <input wire:model.live="search" class="form-control w-50 mx-auto" placeholder="Buscar">

            {{-- Comprueba que haya registros --}}
            @if ($conceptos->count())
                <div class="card-body">
                    {{-- El botón de crear nuevo concepto sólo estará visible para el administrador --}}
                    @can('Administrador')
                        <a class="btn btn-info btn-sm float-right mb-3" href="{{ route('admin.concepts.create') }}">Nuevo</a>
                    @endcan

                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <tr>
                                <th>Nombre</th>
                                {{-- Los botones de edición y eliminación sólo están disponibles para el Administrador --}}
                                @if (auth()->user()->hasRole('Administrador'))
                                    <th colspan="2" class="text-center">Acciones</th>
                                @elseif(auth()->user()->hasRole('Editor'))
                                    <th class="text-center">Accion</th>
                                @endif
                            </tr>
                            @foreach ($conceptos as $concepto)
                                <tr>
                                    <td>{{ $concepto->name }}</td>
                                    {{-- Los botones de edición y eliminación sólo están disponibles para el Administrador --}}
                                    @if (auth()->user()->hasRole('Administrador'))
                                    <td class="text-center" width='10px'>
                                        <a href="{{ route('admin.concepts.edit', $concepto) }}"><i
                                                class="fas fa-fw fa-regular fa-pen text-amarillo-claro"></i></a>
                                    </td>
                                        <td class="text-center" width='10px'>
                                            <form action="{{ route('admin.concepts.destroy', $concepto) }}" method="POST"
                                                style="display:inline;" id="delete-form-{{ $concepto->id }}">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button" onclick="confirmDelete({{ $concepto->id }})"
                                                    style="border:none; background:none; color:rgb(25, 134, 236);">
                                                    <i class="fas fa-fw fa-trash text-rojo-claro"></i>
                                                </button>
                                            </form>
                                        </td>
                                    @elseif(auth()->user()->hasRole('Editor'))
                                        <td class="text-center" width='10px'>
                                            <a href="{{ route('admin.concepts.edit', $concepto) }}"><i
                                                    class="fas fa-fw fa-regular fa-pen text-amarillo-claro"></i></a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{-- Enlaces de paginación --}}
                    {{ $conceptos->links() }}
                </div>
            @else
                <div class="card-body text-center text-azul-claro fs-2">
                    No hay registros con ese criterio de búsqueda
                </div>
            @endif
        </div>
    @else
        {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
        @include('admin.index')
    @endif


</div>
