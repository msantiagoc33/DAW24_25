<div class="container">
    {{-- Vista de los registros históricos, aquellos cuyas reservas están terminadas --}}
    {{-- El listado se muestra por apartamento y el importe total de las reservas. --}}

    {{-- Mostrar los posibles mensaje de errores --}}
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
    </div>

    <div class="card">
        <div class="card-header bg-verde-claro text-center fs-1">
            Listado <strong>histórico</strong> del apartamento: <strong>{{ $nombreApartamento }}</strong>
        </div>
        {{-- Si hay reservas históricas para mostrar --}}
        @if ($reservas->isNotEmpty())
            {{-- Lo podran ver los usuarios con el rol de Consultor --}}
            @can('Consultor')
                <div class="card-body">
                    <div class="w-75 bg-verde-claro p-2 rounded d-flex justify-content-center align-itmes-center mx-auto">
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
                                <input type="text" class="form-control rounded shadow w-auto" wire:model.live="search"
                                    placeholder="Buscar...">
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

                    <br>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm table-historico">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle text-verde-claro" scope="col">#</th>
                                    <th class="text-center align-middle text-verde-claro" scope="col">ENTRADA</th>
                                    <th class="text-center align-middle text-verde-claro" scope="col">SALIDA</th>
                                    <th class="text-center align-middle text-verde-claro" scope="col">
                                        <h4><i class="fa-solid fa-house"></i></h4>
                                    </th>
                                    <th class="text-center align-middle text-verde-claro" scope="col">
                                        <h4><i class="fa-solid fa-users text-verde-claro"></i></h4>
                                    </th>
                                    <th class="text-center align-middle text-verde-claro" scope="col">NOMBRE</th>
                                    <th class="text-center align-middle text-verde-claro" colspan="1" scope="col">
                                        ACCIÓN</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $indiceReservas = $reservas->firstItem() - 1; // Calcula el índice inicial
                                @endphp

                                @foreach ($reservas as $reserva)
                                    @php
                                        $diasDentro = $reserva->fechaEntrada->diffInDays($reserva->fechaSalida, false);
                                    @endphp

                                    <tr>
                                        <td class="text-center" style="width: 5%">{{ ++$indiceReservas }}</td>
                                        <td class="text-center text-nowrap" style="width: 8%">
                                            {{ $reserva->fechaEntrada->format('d-m-Y') }}
                                        </td>
                                        <td class="text-center text-nowrap" style="width: 8%">
                                            {{ $reserva->fechaSalida->format('d-m-Y') }}
                                        </td>
                                        <td class="text-center" style="width: 8%">{{ $diasDentro }}</td>
                                        <td class="text-center" style="width: 8%">{{ $reserva->huespedes }}</td>
                                        <td class="text-left ml-2" style="width: 35%">{{ $reserva->client->name }}</td>

                                        {{-- Accion --}}
                                        <td class="text-center" style="width: 3%">
                                            <a href="{{ route('admin.bookings.show', $reserva->id) }}"><i
                                                    class="fas fa-fw fa-eye text-magenta-claro"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="float-left">
                        Total importe: <strong>{{ number_format($totalImporte, 2, ',', '.') }} €</strong>
                    </div>
                    <div class="mt-3">{{ $reservas->links() }}</div>
                </div>
            @else
                {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
                @include('admin.index')
            @endcan
        @else
            <div class="card-body">
                @can('Consultor')
                    <div
                        class="w-25 bg-verde-claro p-2 rounded d-flex justify-content-center align-itmes-center mx-auto mb-3">
                        <div class="row g-2 align-items-center">
                            <div class="col">
                                @if ($this->search !== '')
                                    <button wire:click='clear' class="form-control rounded shadow w-auto">X</button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-center fs-2 text-gris-claro">
                        <p>No hay reservas en el histórico para este apartamento.</p>
                        <p>O no hay coincidencias con la búsqueda.</p>
                    </div>
                @endcan
            </div>
        @endcan
</div>
