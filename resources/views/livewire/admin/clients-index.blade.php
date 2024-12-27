<div class="container">
    {{-- Mostrar posibles errores --}}
    <div class="erroresMensajes">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-success">
                <strong>{{ session('info') }}</strong>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                <strong>{{ session('success') }}</strong>
            </div>
        @endif
    </div>

    {{-- Comprobar si hay clientes para mostrar --}}
    @if ($clients->isEmpty())
        {{-- Si no hay clientes o no hay resultado de búsqueda, se muestra este tarjeta --}}
        <div class="card">
            <div class="card-body">
                @if ($this->search !== '')
                    <button wire:click='clear' class="form-control rounded shadow w-auto mx-auto">X</button>
                @endif
            </div>

            <div class="card-footer bg-azul-claro text-center text-white fs-2">
                No hay clientes registrados o no hay coincidencia con los criterios de búsqueda.
            </div>
        </div>
    @else
        {{-- Podrán ver la lista de clientes los usuarios con rol de Consultor y Editor --}}
        @if (auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Editor'))
            <div class="card">
                <div class="card-header bg-azul-claro text-center text-gris-claro fs-1">
                    Lista de Clientes
                </div>

                <div class="card-body">
                    <div
                        class="w-75 bg-azul-claro p-2 rounded d-flex justify-content-center align-itmes-center mx-auto">
                        <div class="row g-2 align-items-center">

                            <div class="col">
                                <input type="text" class="form-control rounded shadow w-auto"
                                    wire:model.live="search" placeholder="Buscar...">
                            </div>

                            <div class="col">
                                <select class="form-control text-gris-claro rounded shadow w-auto"
                                    wire:model.live="porPagina">
                                    <option value="5">5 por página</option>
                                    <option value="10">10 por página</option>
                                    <option value="15">15 por página</option>
                                    <option value="25">25 por página</option>
                                    <option value="50">50 por página</option>
                                    <option value="100">100 por página</option>
                                </select>
                            </div>

                            <div class="col">
                                @if ($this->search !== '')
                                    <button wire:click='clear' class="form-control rounded shadow w-auto">X</button>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- El botón de añadir nuevo cliente sólo para los Administradores --}}
                    @can('Administrador')
                        <a class="btn btn-info btn-sm float-left mb-3"
                            href="{{ route('admin.clients.create', ['origen' => 'clientes']) }}">Nuevo
                            cliente</a>
                    @endcan
                    <br>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Teléfono</th>
                                    <th class="text-center">Dirección</th>
                                    <th class="text-center">DNI</th>
                                    <th class="text-center">Pais</th>
                                    @if (auth()->user()->hasRole('Administrador'))
                                        <th class="text-center" colspan="3">Acciones</th>
                                    @elseif (auth()->user()->hasRole('Editor'))
                                        <th class="text-center" colspan="2">Acciones</th>
                                    @elseif('Consultor')
                                        <th class="text-center" colspan="1">Acción</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php $contador = 1; @endphp
                                @foreach ($clients as $index => $cliente)
                                    <tr class="p-50">
                                        <td class="text-center" style="width: 5%">
                                            {{ $index + 1 + ($clients->currentPage() - 1) * $clients->perPage() }}</td>
                                        <td class="text-left ml-2 text-nowrap" style="width: 15%">{{ $cliente->name }}
                                        </td>
                                        <td class="text-center ml-2 text-nowrap" style="width: 8%">{{ $cliente->phone }}
                                        </td>
                                        @if ($cliente->calle_numero)
                                            {{-- Si hay dirección  --}}
                                            <td class="text-left ml-2" style="width: 30%">
                                                {{ $cliente->calle_numero }}
                                                @if ($cliente->cp)
                                                    , {{ $cliente->cp }}
                                                @endif
                                                @if ($cliente->ciudad)
                                                    , {{ $cliente->ciudad }}
                                                @endif
                                                @if ($cliente->provincia)
                                                    ({{ $cliente->provincia }})
                                                @endif
                                            </td>
                                        @else
                                            <td class="text-center ml-2" style="width: 30%">
                                                Sin dirección
                                            </td>
                                        @endif

                                        </td>
                                        <td class="text-center ml-2" style="width: 8%">{{ $cliente->passport }}</td>
                                        <td class="text-center ml-2" style="width: 15%">{{ $cliente->pais->nombre }}
                                        </td>

                                        <td class="text-center" style="width: 3%">
                                            <a href="{{ route('admin.clients.show', $cliente->id) }}"><i
                                                    class="fas fa-fw fa-regular fa-eye text-verde-claro"></i></a>
                                        </td>
                                        {{-- Los botones de editar y eliminar sólo para el Administrador --}}
                                        @if (auth()->user()->hasRole('Administrador'))
                                            <td class="text-center" style="width: 3%">
                                                <a href="{{ route('admin.clients.edit', $cliente->id) }}"><i
                                                        class="fas fa-fw fa-regular fa-pen text-amarillo-claro"></i></a>
                                            </td>

                                            <td class="text-center" style="width: 3%">
                                                <form action="{{ route('admin.clients.destroy', $cliente) }}"
                                                    method="POST" style="display:inline;"
                                                    id="delete-form-{{ $cliente->id }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="button" onclick="confirmDelete({{ $cliente->id }})"
                                                        style="border:none; background:none; color:rgb(25, 134, 236);">
                                                        <i class="fas fa-fw fa-trash text-rojo-claro"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        @elseif (auth()->user()->hasRole('Editor'))
                                            <td class="text-center" style="width: 3%">
                                                <a href="{{ route('admin.clients.edit', $cliente->id) }}"><i
                                                        class="fas fa-fw fa-regular fa-pen text-amarillo-claro"></i></a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- Enlace para la paginación --}}
                <div class="card-footer">
                    <div class="mt-3">{{ $clients->links() }}</div>
                </div>
            </div>
        @else
            {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
            @include('admin.index')
        @endif
    @endif
</div>
