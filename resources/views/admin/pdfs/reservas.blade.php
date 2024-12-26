<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reservas - {{ $apartamento->name }}</title>
</head>

<body>
    <div class="card">
        <div class="card-header">
            <img src="img/logoSANGUT.png" alt="" width="100">
        </div>
        <div class="card-body">
            <h2 style="text-align: center">Reservas para el Apartamento: {{ $apartamento->name }}</h2>
            <table border="1" cellpadding="9" cellspacing="0">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Fecha de Entrada</th>
                        <th>Fecha de Salida</th>
                        <th>Huéspedes</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservas as $reserva)
                        <tr>
                            <td>{{ $reserva->client->name }}</td>
                            <td style="text-align: center">{{ $reserva->fechaEntrada->format('d-m-Y') }}</td>
                            <td style="text-align: center">{{ $reserva->fechaSalida->format('d-m-Y') }}</td>
                            <td style="text-align: center">{{ $reserva->huespedes }}</td>
                            <td style="word-wrap: break-word;">{{ $reserva->comentario }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</body>

</html>
