<div>
    {{-- Vista de todos los usuarios registrados en el sistema --}}

    <div class="card">
        {{-- Sólo puden acceder los usuarios con el rol de Administrador --}}
        @can('Administrador')
            {{-- Si hay usuarios para mostrar --}}
            @if ($users->count())
                @if (session('success'))
                    <div class="alert alert-success">
                        <strong>{{ session('success') }}</strong>
                    </div>
                @endif

                <div class="card-header bg-azul-claro text-center text-gris-claro fs-1">
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
                                            class="fas fa-fw fa-regular fa-eye text-verde-claro"></i></a>
                                </td>
                                <td class="text-center" width='10px'>
                                    <a href="{{ route('admin.users.edit', $user) }}"><i
                                            class="fas fa-fw fa-regular fa-pen text-amarillo-claro"></i></a>
                                </td>
                                <td class="text-center" width='10px'>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                        style="display:inline;" id="delete-form-{{ $user->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $user->id }})"
                                            style="border:none; background:none; color:rgb(25, 134, 236);">
                                            <i class="fas fa-fw fa-trash text-rojo-claro"></i>
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
            @else
                <div class="card-header bg-azul-claro text-center text-white fs-1">
                    No hay registros con ese criterio de búsqueda.
                </div>
                <div class="card-footer">
                    <a class="btn btn-secondary btn-sm float-left mb-3" href="{{ route('admin.users.index') }}">Volver</a>
                </div>
            @endif
        @else
            {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
            @include('admin.index')
        @endcan
    </div>
</div>
