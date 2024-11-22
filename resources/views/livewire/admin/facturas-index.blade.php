<div>

    <style>
        /* Estilo inicial (oculto) */
        .hidden {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease-out;
        }

        /* Estilo desplegado */
        .visible {
            max-height: 500px;
            /* Ajusta según la altura del formulario */
        }
    </style>

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

    <label for="apartamento">Selecciona un Apartamento:</label>
    <select wire:model.live="apartamentoSeleccionado" id="apartamento" class="form-control">
        <option value="">Selecciona un apartamento...</option>
        @foreach ($apartamentos as $apto)
            <option value="{{ $apto->id }}">{{ $apto->name }}</option>
        @endforeach
    </select>

    @if ($apartamento && $apartamento->facturas->isNotEmpty())

        <div class="card">

            <div class="card-header">

                {{-- <h2 class="float-left">Facturas del Apartamento: {{ $apartamento->name }}</h2> --}}

                @can('Administrador')
                    <a class="btn btn-info btn-sm float-right mb-3" href="{{ route('admin.facturas.create') }}">Nueva
                        factura</a>
                @endcan
                <button id="toggleForm" class="btn btn-primary btn-sm float-right mr-3">Consultas</button>
                <button wire:click='resetFilters' class="btn btn-secondary btn-sm float-right mr-3">Recargar
                    listado</button>
                {{-- Formulario de búsqueda --}}
                <div id="hiddenForm" class="hidden w-50 bg-light ">
                    <form wire:submit.prevent="buscarFacturas">
                        @csrf

                        <input wire:model.live='apartment_id' type="hidden" name="apartamento_id"
                            value="{{ $apartamento->id }}">

                        <div class="form-group">
                            <label for="texto">Texto a buscar:</label>
                            <input wire:model='texto' type="text" id="texto" name="texto"
                                class="form-control form-control-sm">
                            @error('texto')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="desde">Desde:</label>
                                <input wire:model='desde' type="date" id="desde" name="desde"
                                    class="form-control form-control-sm">
                                @error('desde')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="hasta">Hasta:</label>
                                <input wire:model='hasta' type="date" id="hasta" name="hasta"
                                    class="form-control form-control-sm">
                                @error('hasta')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="importe_desde">Importe desde:</label>
                                <input wire:model='importe_desde' type="number" id="importe_desde" name="importe_desde"
                                    class="form-control form-control-sm">
                                @error('importe_desde')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="importe_hasta">Importe hasta:</label>
                                <input wire:model='importe_hasta' type="number" id="importe_hasta" name="importe_hasta"
                                    class="form-control form-control-sm">
                                @error('importe_hasta')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Enviar</button>
                    </form>
                </div>
                <h2 class="float-left">Facturas del Apartamento: {{ $apartamento->name }}</h2>
            </div>

            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Importe</th>
                            <th class="text-center">Concepto</th>
                            <th class="text-center">Notas</th>
                            <th class="text-center">Archivo</th>
                            @can('Administrador')
                                <th class="text-center" colspan="2">Acciones</th>
                            @endcan
                        </tr>
                    </thead>
                    @foreach ($facturas as $factura)
                        <tr>
                            <td class="text-center" style="width: 5%">{{ $factura->id }}</td>
                            <td class="text-nowrap text-center" style="width: 10%">{{ $factura->fecha }}</td>
                            <td class="text-right mr-3" style="width: 10%">{{ $factura->importe }}</td>
                            <td style="width: 30%">
                                @foreach ($factura->concepts as $concept)
                                    {{ $concept->name }}{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </td>
                            <td>{{ $factura->notas }}</td>
                            <td class="text-center"style="width: 15%">
                                @if ($factura->file_uri)
                                    <a href="{{ Storage::url($factura->file_uri) }}" target="_blank"
                                        class="btn btn-info" title="Ver Factura">
                                        <i class="fas fa-file-pdf"></i> Ver / Descargar
                                    </a>
                                @else
                                    No disponible
                                @endif
                            </td>
                            @can('Administrador')
                                <td class="text-center" width='10px'>
                                    <a href="{{ route('admin.facturas.edit', $factura->id) }}"><i
                                            class="fas fa-fw fa-regular fa-pen"></i></a>
                                </td>

                                <td class="text-center" width='10px'>
                                    <form action="{{ route('admin.facturas.destroy', $factura) }}" method="POST"
                                        style="display:inline;" id="delete-form-{{ $factura->id }}">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button" onclick="confirmDelete({{ $factura->id }})"
                                            style="border:none; background:none; color:rgb(25, 134, 236);">
                                            <i class="fas fa-fw fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            @endcan
                        </tr>
                    @endforeach
                    {{-- <div>{{ $facturas->links() }}</div> --}}

                </table>
            </div>
        @elseif ($apartamento)
            <p>Este apartamento no tiene facturas asociadas.</p>
        @else
            <p>El apartamento no existe.</p>
    @endif

    <div class="card-footer">
        @if ($totalImporte > 0 && $facturas->count() > 0)
            <td>Suma el total de esta consulta: <strong>{{ number_format($totalImporte, 2) }} €</strong></td>
        @endif
    </div>
    
    <!-- SweetAlert2 JS para la confirmación de eliminación -->
    <script>
        function confirmDelete(facturaId) {
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
                    document.getElementById('delete-form-' + facturaId).submit();
                }
            });
        }
        // Oculta/Muestra el formulario de búsqueda
        document.getElementById('toggleForm').addEventListener('click', function() {
            const form = document.getElementById('hiddenForm');
            form.classList.toggle('visible'); // Alterna entre las clases "hidden" y "visible"
        });
    </script>
</div>
