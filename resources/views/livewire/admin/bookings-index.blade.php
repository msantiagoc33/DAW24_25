<div class="container">
    {{-- Posible vista de Errores --}}
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


    <div class="card">
        <div class="card-header bg-azul-claro text-center text-gris-claro fs-1">
            Listado de reservas del apartamento: <strong>{{ $nombreApartamento }}</strong>
        </div>

        {{-- Comprueba si hay reservas para mostrar --}}
        @if ($reservas->isNotEmpty())
            {{-- Si tiene el rol de Consultor podrá ver la lista de reservas --}}
            @if (auth()->user()->hasRole('Administrador') ||
                    auth()->user()->hasRole('Editor') ||
                    auth()->user()->hasRole('Consultor'))
                <div class="card-body">
                    {{-- si tiene el rol de Administrador podrá ver el botón de crear reserva --}}
                    <div
                        class="w-75 bg-azul-claro p-2 rounded d-flex justify-content-center align-itmes-center mx-auto mb-72">
                        <div class="row g-2 align-items-center">
                            <div class="col">
                                <select wire:model.live="selectedApartment"
                                    class="form-control text-gris-claro rounded shadow w-auto">
                                    <option value="1">Selecciona un apartamento</option>
                                    @foreach ($apartamentos as $apartamento)
                                        <option value="{{ $apartamento->id }}">{{ $apartamento->name }}</option>
                                    @endforeach
                                </select>
                            </div>

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

                    @can('Administrador')
                        <div class="p-2 rounded d-flex justify-content-center align-itmes-center mx-auto mb-72">
                            <div class="">
                                <a class="btn btn-info btn-sm" href="{{ route('admin.bookings.create') }}">Nueva
                                    reserva</a>
                            </div>
                            <div class="">
                                <a class="btn btn-primary btn-sm ml-3" href="{{ route('pdfs.index', $selectedApartment) }}"
                                    target="_blank">
                                    Descargar PDF
                                </a>
                            </div>
                        </div>
                    @endcan
                    <br>

                    <div class="table-responsive">
                        <table class="table table-striped table-sm" id="bookings-table">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle text-azul-claro d-none d-sm-table-cell"
                                        scope="col">#
                                    </th>
                                    <th class="text-center align-middle text-azul-claro" scope="col">ENTRADA</th>
                                    <th class="text-center align-middle text-azul-claro" scope="col">SALIDA</th>
                                    <th class="text-center align-middle text-azul-claro d-none d-sm-table-cell"
                                        scope="col"><i class="fa-solid fa-right-to-bracket fs-4"></i>
                                    </th>
                                    <th class="text-center align-middle text-azul-claro d-none d-sm-table-cell"
                                        scope="col"><i class="fa-solid fa-right-from-bracket fs-4"></i></th>
                                    <th class="text-center align-middle text-azul-claro d-none d-sm-table-cell"
                                        scope="col">
                                        <i class="fa-solid fa-house text-azul-claro fs-4"></i>
                                    </th>
                                    <th class="text-center align-middle text-azul-claro" scope="col">
                                        <i class="fa-solid fa-users text-azul-claro fs-4"></i>
                                    </th>
                                    <th class="text-center align-middle text-azul-claro d-none d-sm-table-cell"
                                        scope="col">
                                        NOMBRE</th>

                                    @if (auth()->user()->hasRole('Administrador'))
                                        <th class="text-center align-middle text-azul-claro" colspan="3"
                                            scope="col">
                                            ACCIONES</th>
                                    @elseif(auth()->user()->hasRole('Editor'))
                                        <th class="text-center align-middle text-azul-claro" colspan="2"
                                            scope="col">
                                            ACCIONES</th>
                                    @elseif(auth()->user()->hasRole('Consultor'))
                                        <th class="text-center align-middle text-azul-claro" scope="col">
                                            ACCIÓN</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reservas as $reserva)
                                    @php
                                        if ($reserva->fechaEntrada <= $hoy) {
                                            $diasParaEntrar = 0;
                                        } else {
                                            $diasParaEntrar =
                                                (int) abs($reserva->fechaEntrada->diffInDays($hoy, false)) + 1;
                                        }

                                        $diasParaSalir = (int) abs($reserva->fechaSalida->diffInDays($hoy, false)) + 1;
                                        $diasDentro =
                                            $reserva->fechaEntrada->diffInDays($reserva->fechaSalida, false) + 1;
                                    @endphp

                                    <tr class="{{ $reserva->fechaEntrada <= $hoy ? 'bg-verde-claro' : '' }}">
                                        <td class="text-center d-none d-sm-table-cell" style="width: 5%">
                                            {{ ++$indiceReservas }}</td>
                                        <td class="text-nowrap text-center" style="width: 8%">
                                            {{ $reserva->fechaEntrada->format('d-m-Y') }}
                                        </td>
                                        <td class="text-nowrap text-center" style="width: 8%">
                                            {{ $reserva->fechaSalida->format('d-m-Y') }}
                                        </td>
                                        <td class="text-center d-none d-sm-table-cell" style="width: 8%">
                                            {{ $diasParaEntrar == 0 ? '-' : $diasParaEntrar }}</td>
                                        <td class="text-center d-none d-sm-table-cell" style="width: 8%">
                                            {{ $diasParaSalir }}</td>
                                        <td class="text-center d-none d-sm-table-cell" style="width: 8%">
                                            {{ $diasDentro }}</td>
                                        <td class="text-center" style="width: 8%">{{ $reserva->huespedes }}</td>
                                        <td class="text-left ml-2 d-none d-sm-table-cell" style="width: 35%">
                                            {{ $reserva->client->name }}</td>

                                        <td class="text-center">
                                            <a href="{{ route('admin.bookings.show', $reserva->id) }}"><i
                                                    class="fas fa-fw fa-eye text-verde-claro"></i></a>
                                        </td>

                                        {{-- Estos botones sólo se le muestran al Administrador --}}
                                        @if (auth()->user()->hasRole('Administrador'))
                                            <td class="text-center">
                                                <a href="{{ route('admin.bookings.edit', $reserva->id) }}"><i
                                                        class="fas fa-fw fa-regular fa-pen text-amarillo-claro"></i></a>
                                            </td>

                                            <td class="text-center" style=" width: 4%; ">
                                                {{-- El id del formulario está formado por la frase 'delete-form-' más el id de la reserva utilizado para identificar al registro que se va a eliminar --}}
                                                <form action="{{ route('admin.bookings.destroy', $reserva) }}"
                                                    method="POST" style="display:inline;"
                                                    id="delete-form-{{ $reserva->id }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="button"
                                                        onclick="confirmDelete({{ $reserva->id }})"
                                                        style="border:none; background:none; color:rgb(25, 134, 236);">
                                                        <i class="fas fa-fw fa-trash text-rojo-claro"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        @elseif(auth()->user()->hasRole('Editor'))
                                            <td class="text-center">
                                                <a href="{{ route('admin.bookings.edit', $reserva->id) }}"><i
                                                        class="fas fa-fw fa-regular fa-pen text-amarillo-claro"></i></a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer">
                    {{-- Muestra el importe del total de las reservas --}}
                    <div class="float-left">
                        Total importe: <strong>{{ number_format($totalImporte, 2, ',', '.') }} €</strong>
                    </div>

                    {{-- Enlace para paginación --}}
                    <div class="mt-3">{{ $reservas->links() }}</div>
                </div>
            @else
                {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
                @include('admin.index')
            @endif

            {{-- Aquí entrará cuando estemos haciendo una búsquda sin coincidencias --}}
        @elseif($search != '')
            @if (auth()->user()->hasRole('Administrador') ||
                    auth()->user()->hasRole('Editor') ||
                    auth()->user()->hasRole('Consultor'))
                <div class="w-25 p-2 rounded d-flex justify-content-center align-itmes-center mx-auto mb-3">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <button wire:click='clear'
                                class="bg-azul-claro text-gris-claro form-control rounded shadow w-auto">X</button>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-center fs-2 text-gris-claro">
                    <p>No hay coincidencias con la búsqueda.</p>
                </div>
            @endif

            {{-- Aquí entrará cuando no haya datos en el apartamento escogido --}}
        @else
            <div class="card-body">
                @if (auth()->user()->hasRole('Administrador') ||
                        auth()->user()->hasRole('Editor') ||
                        auth()->user()->hasRole('Consultor'))
                    <div class="w-25 p-2 rounded d-flex justify-content-center align-itmes-center mx-auto mb-3">
                        <div class="row g-2 align-items-center">
                            <div class="col">
                                <button wire:click='clear'
                                    class="bg-azul-claro text-gris-claro form-control rounded shadow w-auto">X</button>
                            </div>
                        </div>
                    </div>
                    <div
                        class="w-50 bg-azul-claro p-2 rounded d-flex justify-content-center align-itmes-center mx-auto mb-72">
                        <select wire:model.live="selectedApartment"
                            class="form-control text-gris-claro rounded shadow w-auto">
                            <option value="1">Selecciona un apartamento</option>
                            @foreach ($apartamentos as $apartamento)
                                <option value="{{ $apartamento->id }}">{{ $apartamento->name }}</option>
                            @endforeach
                        </select>

                        <a class="btn btn-info btn-sm ml-5 text-white fs-5"
                            href="{{ route('admin.bookings.create') }}">Nueva
                            reserva</a>

                    </div>
                    <div class="card-footer text-center fs-2 text-gris-claro mt-5">
                        <p>No hay reservas para este apartamento.</p>
                    </div>
                @endif
            </div>

        @endif
    </div>
</div>
