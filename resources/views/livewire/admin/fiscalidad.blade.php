<div class="container">
    {{-- Vista del balance fiscal por año y apartamento --}}
    {{-- El año tiene que ser superior al año 2000 y no ser mayor que el año actual. --}}

    <div class="card w-75 mx-auto">
        <div class="card-header bg-rojo-claro text-center text-white fs-1">
            @if ($year && $apartment_id)
                @if (!$errors->any())
                    Balance fiscal del año {{ $year }} de {{ $nombreApartamento }}
                @else
                    Por favor, selecciona el apartamento y el año
                @endif
            @else
                Por favor, selecciona el apartamento y el año
            @endif

        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label for="apartment_id">Apartamento</label>
                        <select name="apartment_id" id="apartment_id" class="form-control custom-input" required
                            wire:model='apartment_id' wire:change="calculoTotales">
                            <option value="">Selecciona el apartamento...</option>
                            @foreach ($apartamentos as $apartamento)
                                <option value="{{ $apartamento->id }}">{{ $apartamento->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="year">Año</label>
                        <input type="number" name="year" id="year" class="form-control custom-input"
                            placeholder="Año" value="{{ old('year') }}" min="1900" max="{{ date('Y') }}"
                            wire:change="calculoTotales" wire:model='year'>
                        @error('year')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            @if ($reservasAnnio == null || $reservasAnnio->isEmpty())
                <h2 class="fs-3 py-3">Aún no hay datos para mostrar. Selecciona apartamento y año.</h2>
            @else
                @php
                    // Calculo de gatos dividido entre el número de días del año
                    $entreTodoElAnnio = floatval($totalFacturas) / 365; // floatval evita errores de redondeo si viene un string

                    // Cálculo de los gastos imputables por el número de días alquilado
                    $Totalimputable = $entreTodoElAnnio * $totalDias;
                @endphp

                <div class="py-12">
                    <div class="input-group flex row">
                        <div class="container mx-auto d-flex justify-content-around">
                            <h2 class="display-6">Días alquilado: {{ $totalDias }}</h2>
                        </div>
                        <div class="w-75 container mx-auto">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="h4">Total ingresos en {{ $year }}: </td>
                                        <td class="text-right text-danger h4">
                                            {{ number_format($totalHistorico, 2, ',', '.') }} € </td>
                                    </tr>

                                    <tr>
                                        <td class="h4">Total gastos en {{ $year }}:</td>
                                        <td class="text-right text-danger h4">
                                            {{ number_format($totalFacturas, 2, ',', '.') }} €</td>
                                    </tr>


                                    <tr class="h4">
                                        <td class="">Gastos computables por {{ $totalDias }} días
                                            alquilado:</td>
                                        <td class="text-right text-success h4">
                                            {{ number_format($Totalimputable, 2, ',', '.') }} €</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
            @endif
        </div>
    </div>
</div>
