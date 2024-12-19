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
            @can('Consultor')
                <div class="card-body">
                    {{-- si tiene el rol de Administrador podrá ver el botón de crear reserva --}}
                    @can('Administrador')
                        <a class="btn btn-info btn-sm float-right mb-3" href="{{ route('admin.bookings.create') }}">Nueva
                            reserva</a>
                    @endcan

                    <label for="apartment-select" class="form-label">Selecciona un Apartamento:</label>
                    <select wire:model.live='selectedApartment' id="selectedApartment"
                        class="form-control form-select bg-azul-claro text-gris-claro">
                        @foreach ($apartamentos as $apartamento)
                            <option value="{{ $apartamento->id }}">{{ $apartamento->name }}</option>
                        @endforeach
                    </select>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle text-azul-claro d-none d-sm-table-cell" scope="col">#</th>
                                    <th class="text-center align-middle text-azul-claro" scope="col">ENTRADA</th>
                                    <th class="text-center align-middle text-azul-claro" scope="col">SALIDA</th>
                                    <th class="text-center align-middle text-azul-claro d-none d-sm-table-cell" scope="col">DÍAS PARA ENTRAR
                                    </th>
                                    <th class="text-center align-middle text-azul-claro d-none d-sm-table-cell" scope="col">DÍAS PARA SALIR</th>
                                    <th class="text-center align-middle text-azul-claro d-none d-sm-table-cell" scope="col">
                                        <h4><i class="fa-solid fa-house text-azul-claro"></i></h4>
                                    </th>
                                    <th class="text-center align-middle text-azul-claro" scope="col">
                                        <h4><i class="fa-solid fa-users text-azul-claro"></i></h4>
                                    </th>
                                    <th class="text-center align-middle text-azul-claro d-none d-sm-table-cell" scope="col">NOMBRE</th>

                                    @can('Administrador')
                                        <th class="text-center align-middle text-azul-claro" colspan="3" scope="col">
                                            ACCIONES</th>
                                    @elsecan('Consultor')
                                        <th class="text-center align-middle text-azul-claro" colspan="1" scope="col">
                                            ACCIÓN</th>
                                    @endcan
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
                                        <td class="text-center d-none d-sm-table-cell" style="width: 5%">{{ ++$indiceReservas }}</td>
                                        <td class="text-nowrap text-center" style="width: 8%">
                                            {{ $reserva->fechaEntrada->format('d-m-Y') }}
                                        </td>
                                        <td class="text-nowrap text-center" style="width: 8%">
                                            {{ $reserva->fechaSalida->format('d-m-Y') }}
                                        </td>
                                        <td class="text-center d-none d-sm-table-cell" style="width: 8%">{{ $diasParaEntrar }}</td>
                                        <td class="text-center d-none d-sm-table-cell" style="width: 8%">{{ $diasParaSalir }}</td>
                                        <td class="text-center d-none d-sm-table-cell" style="width: 8%">{{ $diasDentro }}</td>
                                        <td class="text-center" style="width: 8%">{{ $reserva->huespedes }}</td>
                                        <td class="text-left ml-2 d-none d-sm-table-cell" style="width: 35%">{{ $reserva->client->name }}</td>

                                        <td class="text-center">
                                            <a href="{{ route('admin.bookings.show', $reserva->id) }}"><i
                                                    class="fas fa-fw fa-eye text-verde-claro"></i></a>
                                        </td>

                                        {{-- Estos botones sólo se le muestran al Administrador --}}
                                        @can('Administrador')
                                            <td class="text-center">
                                                <a href="{{ route('admin.bookings.edit', $reserva->id) }}"><i
                                                        class="fas fa-fw fa-regular fa-pen text-amarillo-claro"></i></a>
                                            </td>

                                            <td class="text-center" style=" width: 4%; ">
                                                {{-- El id del formulario está formado por la frase 'delete-form-' más el id de la reserva utilizado para identificar al registro que se va a eliminar --}}
                                                <form action="{{ route('admin.bookings.destroy', $reserva) }}" method="POST"
                                                    style="display:inline;" id="delete-form-{{ $reserva->id }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="button" onclick="confirmDelete({{ $reserva->id }})"
                                                        style="border:none; background:none; color:rgb(25, 134, 236);">
                                                        <i class="fas fa-fw fa-trash text-rojo-claro"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        @endcan
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
            @endcan
        @else
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
                    <br>
                @endcan
            </div>

            <div class="card-footer">
                <h2 class="text-center">No hay reservas para este apartamento.</h2>
            </div>
        @endif
    </div>
    {{-- Script que muestra una ventana modal para confirmar eliminación de registro --}}
    <script>
        function confirmDelete(clienteId) {
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
                    document.getElementById('delete-form-' + clienteId).submit();
                }
            });
        }
    </script>

</div>
