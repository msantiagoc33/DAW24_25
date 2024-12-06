<div>
    {{-- Errores --}}
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

        @if ($reservas->isNotEmpty())
            @can('Consultor')
                <div class="card-body">
                    @can('Consultor')

                        <label for="apartment-select" class="form-label">Selecciona un Apartamento:</label>
                        <select wire:model.live='selectedApartment' id="selectedApartment"
                            class="form-control form-select bg-azul-claro text-white">
                            <option value="">Selecciona un apartamento ...</option>
                            @foreach ($apartamentos as $apartamento)
                                <option value="{{ $apartamento->id }}">{{ $apartamento->name }}</option>
                            @endforeach
                        </select>
                    @endcan
                    <br>
                    <table class="table table-striped table-bordered table-sm table-historico">
                        <thead>
                            <tr>
                                <th class="text-center align-middle" scope="col">#</th>
                                <th class="text-center align-middle" scope="col">ENTRADA</th>
                                <th class="text-center align-middle" scope="col">SALIDA</th>
                                <th class="text-center align-middle" scope="col">
                                    <h4><i class="fa-solid fa-house"></i></h4>
                                </th>
                                <th class="text-center align-middle" scope="col">
                                    <h4><i class="fa-solid fa-users"></i></h4>
                                </th>
                                <th class="text-center align-middle" scope="col">NOMBRE</th>
                                <th class="text-center align-middle" colspan="1" scope="col">ACCIÓN</th>
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
                                    <td class="text-center" style="width: 8%">{{ $reserva->fechaEntrada->format('d-m-Y') }}
                                    </td>
                                    <td class="text-center" style="width: 8%">{{ $reserva->fechaSalida->format('d-m-Y') }}
                                    </td>
                                    <td class="text-center" style="width: 8%">{{ $diasDentro }}</td>
                                    <td class="text-center" style="width: 8%">{{ $reserva->huespedes }}</td>
                                    <td class="text-left ml-2" style="width: 35%">{{ $reserva->client->name }}</td>

                                    @can('Consultor')
                                        <td class="text-center">
                                            <a href="{{ route('admin.bookings.show', $reserva->id) }}"><i
                                                    class="fas fa-fw fa-eye"></i></a>
                                        </td>
                                    @endcan
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
                @php
                    $nombre = auth()->user()->name; // Obtener el nombre del usuario
                    $corto = strstr($nombre, ' ', true); // Obtener la parte antes del primer espacio
                @endphp
                <h2>{{ $corto }}, no puedes ver el histórico de reservas, puede que no tengas aún ningún permiso.
                    Habla con el
                    Administrador.</h2> <!-- Imprimir el valor de $corto correctamente -->
            @endcan
        @else
            <h2 class="text-center">No hay reservas para este apartamento.</h2>
        @endcan

</div>
