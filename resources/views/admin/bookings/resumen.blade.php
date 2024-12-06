@extends('adminlte::page')

@section('title', 'Resumen')

@section('content_header')
    <br>
    @can('Consultor')
        <div class="card">
            <div class="card-header bg-rojo-claro text-center text-white fs-1">Resumenes anuales por apartamento</div>
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
            <div class="card-footer text-center" id="clock"></div>
        </div>
    @else
        @include('admin.index')
    @endcan
@stop

@section('css')

@stop

@section('js')
    <script>
        function updateClock() {
            const now = new Date();
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            };
            document.getElementById('clock').innerHTML = now.toLocaleString('es-ES', options);
        }

        // Actualiza la hora inmediatamente al cargar la página
        updateClock();
        // Luego, actualiza cada segundo
        setInterval(updateClock, 1000);
    </script>
@stop
