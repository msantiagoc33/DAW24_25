<div class="container">
    {{-- Vista que muestra todas las facturas filtradas por apartamento --}}

    @can('Consultor')
        {{-- Muestra posibles mensajes --}}
        <div class="errores">
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
            {{-- Comprueba que haya apartamento seleccionado y que haya facturas para ese apartamento --}}
            @if ($apartamento && $apartamento->facturas->isNotEmpty())
                <div class="card-header bg-azul-claro text-center text-gris-claro fs-1">
                    Facturas del Apartamento: {{ $apartamento->name }}
                </div>

                <div class="card-body">
                    <label class="fs-5" for="apartamento">Selecciona un Apartamento:</label>
                    <select wire:model.live="apartamentoSeleccionado" id="apartamento"
                        class="form-control form-select bg-azul-claro text-white">
                        <option value="1">Selecciona un apartamento...</option>
                        @foreach ($apartamentos as $apto)
                            <option value="{{ $apto->id }}">{{ $apto->name }}</option>
                        @endforeach
                    </select>
                    <br>
                    {{-- Botón de añadir nueva factura sólo para el usuario Administrador --}}
                    @can('Administrador')
                        <a class="btn btn-info btn-sm float-right mb-3" href="{{ route('admin.facturas.create') }}">Nueva
                            factura</a>
                    @endcan

                    {{-- Este botón muestra u oculta el formulario de búsqueda --}}
                    <button id="toggleForm" class="btn btn-primary btn-sm float-right mr-3">Consultas</button>

                    {{-- Botón para recargar todas las facturas despues de haber hecho una consulta --}}
                    <button wire:click='resetFilters' class="btn btn-secondary btn-sm float-right mr-3">X</button>
                    <br>
                    {{-- Formulario de búsqueda que se muestra al pulsar el botón de Consultas --}}
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
                    <br>
                    {{-- Tabla con los registros de facturas --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-sm" id="facturas">
                            <thead>
                                <tr>
                                    <th class="text-center d-none d-sm-table-cell">ID</th>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Importe</th>
                                    <th class="text-center">Concepto</th>
                                    <th class="text-center d-none d-sm-table-cell">Notas</th>
                                    <th class="text-center">Archivo</th>
                                    @can('Administrador')
                                        <th colspan="3" class="text-center">Acciones</th>
                                    @else
                                        <th colspan="3" class="text-center">Accion</th>
                                    @endcan
                                </tr>
                            </thead>

                            <tbody>
                                @php $contador = 1; @endphp
                                @foreach ($facturas as $index => $factura)
                                    <tr>
                                        <td class="text-center align-middle d-none d-sm-table-cell" style="width: 5%">{{  $index + 1 }}</td>

                                        <td class="text-nowrap text-center align-middle" style="width: 10%">
                                            {{ $factura->fecha }}
                                        </td>

                                        <td class="text-right mr-3 align-middle" style="width: 10%">{{ $factura->importe }}
                                        </td>

                                        <td style="width: 30%" class="align-middle">
                                            @foreach ($factura->concepts as $concept)
                                                {{ $concept->name }}{{ !$loop->last ? ', ' : '' }}
                                            @endforeach
                                        </td>

                                        <td class="align-middle d-none d-sm-table-cell">{{ $factura->notas }}</td>

                                        <td class="text-center align-middle"style="width: 15%">
                                            @if ($factura->file_uri)
                                                <a href="{{ Storage::url($factura->file_uri) }}" target="_blank"
                                                    class="btn btn-info btn-sm" title="Ver Factura">
                                                    <i class="fas fa-file-pdf"></i> Descargar
                                                </a>
                                            @else
                                                No disponible
                                            @endif
                                        </td>

                                        <td class="text-center align-middle" width='10px'>
                                            <a href="{{ route('admin.facturas.show', $factura->id) }}"><i
                                                    class="fas fa-eye text-verde-claro"></i></a>
                                        </td>

                                        {{-- Botones de edición y eliminación sólo disponibles para usuario Administrador --}}
                                        @can('Administrador')
                                            <td class="text-center align-middle" width='10px'>
                                                <a href="{{ route('admin.facturas.edit', $factura->id) }}"><i
                                                        class="fas fa-fw fa-regular fa-pen text-amarillo-claro"></i></a>
                                            </td>

                                            <td class="text-center align-middle" width='10px'>
                                                <form action="{{ route('admin.facturas.destroy', $factura) }}" method="POST"
                                                    style="display:inline;" id="delete-form-{{ $factura->id }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="button" onclick="confirmDelete({{ $factura->id }})"
                                                        style="border:none; background:none; color:rgb(25, 134, 236);">
                                                        <i class="fas fa-fw fa-trash text-rojo-claro"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                            </tbody>
                            {{-- <div>{{ $facturas->links() }}</div> --}}
                        </table>
                    </div>
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
        </div>
    @endcan
</div>
