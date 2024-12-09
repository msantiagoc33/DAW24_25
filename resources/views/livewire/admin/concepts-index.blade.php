<div>
    @can('Consultor')
        @if ($conceptos->count())
            @if (session('success'))
                <div class="alert alert-success">
                    <strong>{{ session('success') }}</strong>
                </div>
            @endif
            <div class="card">
                <div class="card-header bg-azul-claro text-center text-white fs-1">
                    Lista de Conceptos
                </div>

                <div class="card-body">
                    @can('Administrador')
                        <a class="btn btn-info btn-sm float-right mb-3" href="{{ route('admin.concepts.create') }}">Nuevo</a>
                    @endcan
                    <br>
                    <input wire:model.live="search" class="form-control" placeholder="Buscar">
                    <br>
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Nombre</th>
                            <th colspan="3" class="text-center">Acciones</th>
                        </tr>
                        @foreach ($conceptos as $concepto)
                            <tr>
                                <td>{{ $concepto->name }}</td>
                                <td class="text-center" width='10px'>
                                    <a href="{{ route('admin.concepts.show', $concepto) }}"><i class="fas fa-eye"></i></a>
                                </td>
                                @can('Administrador')
                                    <td class="text-center" width='10px'>
                                        <a href="{{ route('admin.concepts.edit', $concepto) }}"><i
                                                class="fas fa-fw fa-regular fa-pen"></i></a>
                                    </td>
                                    <td class="text-center" width='10px'>
                                        <form action="{{ route('admin.concepts.destroy', $concepto) }}" method="POST"
                                            style="display:inline;" id="delete-form-{{ $concepto->id }}">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" onclick="confirmDelete({{ $concepto->id }})"
                                                style="border:none; background:none; color:rgb(25, 134, 236);">
                                                <i class="fas fa-fw fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="card-footer">
                    {{ $conceptos->links() }}
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
        <h1>{{ $corto }} no tiene permisos para ver los conceptos. Puede que no tenga aún roles.</h1>
    @endcan

    <script>
        function confirmDelete(conceptoId) {
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
                    document.getElementById('delete-form-' + conceptoId).submit();
                }
            });
        }
    </script>
</div>
