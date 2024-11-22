<div>
    @can('Consultor')
        @if ($conceptos->count())
            @if (session('success'))
                <div class="alert alert-success">
                    <strong>{{ session('success') }}</strong>
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    @can('Administrador')
                        <a class="btn btn-info btn-sm float-right mb-3" href="{{ route('admin.concepts.create') }}">Nuevo</a>
                    @endcan
                    <h1>Lista de conceptos</h1>
                    <input wire:model="search" class="form-control" placeholder="Buscar">
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>Nombre</th>
                            <th colspan="3">Acciones</th>
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
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('¿Estás seguro de que deseas eliminar este concepto ?');"
                                                style="border:none; background:none; color:rgb(25, 134, 236);">
                                                <i class="fas fa-trash"></i>
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
</div>
