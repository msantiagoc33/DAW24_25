<div>
    @can('Administrador')

        @if ($users->count())
            @if (session('success'))
                <div class="alert alert-success">
                    <strong>{{ session('success') }}</strong>
                </div>
            @endif
            <div class="card">
                <div class="card-header bg-azul-claro text-center text-white fs-1">
                    Lista de usuarios
                </div>

                <div class="card-body">
                    <a class="btn btn-info btn-sm float-left mb-3" href="{{ route('admin.users.create') }}">Nuevo</a>
                    <input wire:model.live='search' class="form-control" placeholder="Buscar por nombre o correo">
                    <br>
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th colspan="3" class="text-center">Acciones</th>

                        </tr>

                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>

                                <td class="text-center" width='10px'>
                                    <a href="{{ route('admin.users.show', $user) }}"><i
                                            class="fas fa-fw fa-regular fa-eye"></i></a>
                                </td>
                                <td class="text-center" width='10px'>
                                    <a href="{{ route('admin.users.edit', $user) }}"><i
                                            class="fas fa-fw fa-regular fa-pen"></i></a>
                                </td>
                                <td class="text-center" width='10px'>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                        style="display:inline;" id="delete-form-{{ $user->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $user->id }})"
                                            style="border:none; background:none; color:rgb(25, 134, 236);">
                                            <i class="fas fa-fw fa-trash"></i>
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @endforeach

                    </table>
                </div>
                <div class="card-footer">
                    {{ $users->links() }}
                </div>
            </div>
        @else
            <div class="card-body">
                <strong>No hay registros</strong>
            </div>
        @endif
    @else
        @php
            $nombre = auth()->user()->name; // Obtener el nombre del usuario
            $corto = strstr($nombre, ' ', true); // Obtener la parte antes del primer espacio
        @endphp
        <h1>{{ $corto }} no tiene permisos para ver los usuarios.</h1>
    @endcan
    <script>
        function confirmDelete(userId) {
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
                    document.getElementById('delete-form-' + userId).submit();
                }
            });
        }
    </script>
</div>
