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
                    <label for="apartment-select" class="form-label">Selecciona un Apartamento:</label>
                    <select wire:model.live='selectedApartment' id="selectedApartment"
                        class="form-control form-select bg-verde-claro text-white">
                        @foreach ($apartamentos as $apartamento)
                            <option value="{{ $apartamento->id }}">{{ $apartamento->name }}</option>
                        @endforeach
                    </select>
                    <br>

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
                                <th class="text-center align-middle text-verde-claro" colspan="1" scope="col">ACCIÓN</th>
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
                                    <td class="text-center text-nowrap" style="width: 8%">{{ $reserva->fechaEntrada->format('d-m-Y') }}
                                    </td>
                                    <td class="text-center text-nowrap" style="width: 8%">{{ $reserva->fechaSalida->format('d-m-Y') }}
                                    </td>
                                    <td class="text-center" style="width: 8%">{{ $diasDentro }}</td>
                                    <td class="text-center" style="width: 8%">{{ $reserva->huespedes }}</td>
                                    <td class="text-left ml-2" style="width: 35%">{{ $reserva->client->name }}</td>

                                    {{-- Accion --}}
                                    <td class="text-center"  style="width: 3%">
                                        <a href="{{ route('admin.bookings.show', $reserva->id) }}"><i
                                                class="fas fa-fw fa-eye text-magenta-claro"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
            <h2 class="text-center">No hay reservas para este apartamento.</h2>
        @endcan
</div>
