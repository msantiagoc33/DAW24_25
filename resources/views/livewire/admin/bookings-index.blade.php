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
        <div class="card-header">
            @can('Administrador')
                <a class="btn btn-info btn-sm float-right mb-3" href="{{ route('admin.bookings.create') }}">Nueva
                    reserva</a>
            @endcan

            @can('Consultor')
                <h1>Listado de reservas del apartamento: <strong>{{ $nombreApartamento }}</strong></h1>
                <label for="apartment-select" class="form-label">Selecciona un Apartamento:</label>
                <select wire:model.live='selectedApartment' id="selectedApartment"
                    class="form-control form-select bg-azul-claro text-white">
                    <option value="">Selecciona un apartamento ...</option>
                    @foreach ($apartamentos as $apartamento)
                        <option value="{{ $apartamento->id }}">{{ $apartamento->name }}</option>
                    @endforeach
                </select>
                </h1>
            @endcan
        </div>

        @if ($reservas->isNotEmpty())
            @can('Consultor')
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center align-middle" scope="col">#</th>
                                <th class="text-center align-middle" scope="col">ENTRADA</th>
                                <th class="text-center align-middle" scope="col">SALIDA</th>
                                <th class="text-center align-middle" scope="col">DÍAS PARA ENTRAR</th>
                                <th class="text-center align-middle" scope="col">DÍAS PARA SALIR</th>
                                <th class="text-center align-middle" scope="col">
                                    <h4><i class="fa-solid fa-building"></i></h4>
                                </th>
                                <th class="text-center align-middle" scope="col">
                                    <h4><i class="fa-solid fa-users"></i></h4>
                                </th>
                                <th class="text-center align-middle" scope="col">NOMBRE</th>

                                @can('Administrador')
                                    <th class="text-center align-middle" colspan="3" scope="col">ACCIONES</th>
                                @elsecan('Consultor')
                                    <th class="text-center align-middle" colspan="1" scope="col">ACCIÓN</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservas as $reserva)
                                @php
                                    $diasParaEntrar = abs($reserva->fechaEntrada->diffInDays($hoy, false));
                                    $diasParaSalir = abs($reserva->fechaSalida->diffInDays($hoy, false));
                                    $diasDentro = $reserva->fechaEntrada->diffInDays($reserva->fechaSalida, false);

                                @endphp
                                <tr style="background-color: {{ $reserva->fechaEntrada <= $hoy ? '#3bb841' : '' }}">
                                    <td class="text-center" style="width: 5%">{{ ++$indiceReservas }}</td>
                                    <td class="text-center" style="width: 8%">{{ $reserva->fechaEntrada->format('d-m-Y') }}
                                    </td>
                                    <td class="text-center" style="width: 8%">{{ $reserva->fechaSalida->format('d-m-Y') }}
                                    </td>
                                    <td class="text-center" style="width: 8%">{{ $diasParaEntrar }}</td>
                                    <td class="text-center" style="width: 8%">{{ $diasParaSalir }}</td>
                                    <td class="text-center" style="width: 8%">{{ $diasDentro }}</td>
                                    <td class="text-center" style="width: 8%">{{ $reserva->huespedes }}</td>
                                    <td class="text-left ml-2" style="width: 35%">{{ $reserva->client->name }}</td>

                                    @can('Consultor')
                                        <td class="text-center">
                                            <a href="{{ route('admin.bookings.show', $reserva->id) }}"><i
                                                    class="fas fa-fw fa-eye"></i></a>
                                        </td>
                                    @endcan

                                    @can('Administrador')
                                        <td class="text-center">
                                            <a href="{{ route('admin.bookings.edit', $reserva->id) }}"><i
                                                    class="fas fa-fw fa-regular fa-pen"></i></a>
                                        </td>

                                        <td class="text-center" width='auto'>
                                            <form action="{{ route('admin.bookings.destroy', $reserva) }}" method="POST"
                                                style="display:inline;" id="delete-form-{{ $reserva->id }}">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button" onclick="confirmDelete({{ $reserva->id }})"
                                                    style="border:none; background:none; color:rgb(25, 134, 236);">
                                                    <i class="fas fa-fw fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    <div class="mt-3">{{ $reservas->links() }}</div>
                </div>
            @else
                @php
                    $nombre = auth()->user()->name; // Obtener el nombre del usuario
                    $corto = strstr($nombre, ' ', true); // Obtener la parte antes del primer espacio
                @endphp
                <h2>{{ $corto }}, no puedes ver las reservas, puede que no tengas aún ningún permiso. Habla con el
                    Administrador.</h2> <!-- Imprimir el valor de $corto correctamente -->
            @endcan
        @else
            <h2 class="text-center">No hay reservas para este apartamento.</h2>
        @endcan

        <div id="calendar"></div>
</div>

<!-- SweetAlert2 JS para la confirmación de eliminación -->
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

</script>
</div>
