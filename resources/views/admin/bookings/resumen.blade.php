@extends('adminlte::page')
{{-- Vista que muestra el resumen  por año de los ingresos, las reservas por año, el apartamento y dias alquilado --}}

@section('title', 'Resumen reservas')

@section('content_header')
    <div class="container">
        <br>
        {{-- Esta vista estará visible a los usuarios con el rol de Consultor --}}
        @can('Consultor')
            <div class="card">
                <div class="card-header bg-rojo-claro text-center text-white fs-1">Resumen anual por apartamento</div>
                <div class="card-body">
                    <table class="table-resumen table table-bordered table-sm">
                        <thead>
                            <tr class="text-center">
                                <th>AÑO</th>
                                <th>APARTAMENTO</th>
                                <th>DIAS ALQUILADO</th>
                                <th>IMPORTE TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($totalPorYears as $year)
                                <tr>
                                    <td class="text-center">{{ $year['anio'] }}</td>
                                    <td>{{ $year->apartment->name }}</td>
                                    <td class="text-end pe-5">{{ $year['total_dias'] }}</td>
                                    <td class="text-end pe-5">{{ number_format($year['total'], 2, ',', '.') }} €</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
            @include('admin.index')
        @endcan
    </div>
@stop

@section('css')

@stop

@section('js')

@stop
