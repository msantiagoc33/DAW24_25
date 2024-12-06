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

    @if ($clients->isEmpty())
        <h2>No hay clientes registradors.</h2>
    @else
        @can('Consultor')
            <div class="card">
                <div class="card-header">

                    <div class="card-header bg-azul-claro text-center text-white fs-1">
                        Lista de Clientes
                    </div>
                </div>

                <div class="card-body">
                    @can('Administrador')
                        <a class="btn btn-info btn-sm float-left mb-3" href="{{ route('admin.clients.create') }}">Nuevo
                            cliente</a>
                    @endcan
                    <br>
                    <table class="table table-striped table-bordered table-sm">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Teléfono</th>
                                <th class="text-center">Dirección</th>
                                <th class="text-center">DNI</th>
                                <th class="text-center">Pais</th>
                                @can('Administrador')
                                    <th class="text-center" colspan="3">Acciones</th>
                                @elsecan('Consultor')
                                    <th class="text-center" colspan="1">Acción</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $cliente)
                                <tr class="p-50">
                                    <td class="text-center" style="width: 5%">{{ $cliente->id }}</td>
                                    <td class="text-left ml-2 text-nowrap" style="width: 15%">{{ $cliente->name }}</td>
                                    <td class="text-center ml-2 text-nowrap" style="width: 8%">{{ $cliente->phone }}</td>
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
                                    <td class="text-center ml-2" style="width: 15%">{{ $cliente->pais->nombre }}</td>

                                    <td class="text-center">
                                        <a href="{{ route('admin.clients.show', $cliente->id) }}"><i
                                                class="fas fa-fw fa-regular fa-eye"></i></a>
                                    </td>

                                    @can('Administrador')
                                        <td class="text-center">
                                            <a href="{{ route('admin.clients.edit', $cliente->id) }}"><i
                                                    class="fas fa-fw fa-regular fa-pen"></i></a>
                                        </td>

                                        <td class="text-center" width='auto'>
                                            <form action="{{ route('admin.clients.destroy', $cliente) }}" method="POST"
                                                style="display:inline;" id="delete-form-{{ $cliente->id }}">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button" onclick="confirmDelete({{ $cliente->id }})"
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
                    <div class="mt-3">{{ $clients->links() }}</div>
                </div>
            </div>
        @else
            @php
                $nombre = auth()->user()->name; // Obtener el nombre del usuario
                $corto = strstr($nombre, ' ', true); // Obtener la parte antes del primer espacio
            @endphp
            <p>Bienvenid@ {{ $corto }}</p> <!-- Imprimir el valor de $corto correctamente -->
        @endcan
    @endif

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
</div>
