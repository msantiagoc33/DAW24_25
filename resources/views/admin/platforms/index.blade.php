@extends('adminlte::page')

@section('title', 'Platforms-index')

@section('content_header')

@stop

@section('content')
    @can('Consultor')
        <br>
        @if ($platforms->count())
            <div class="card">
                <div class="card-header">
                    <h2>Listado de plataformas.</h2>
                    @can('Administrador')
                        <a class="btn btn-info btn-sm float-right mb-3" href="{{ route('admin.platforms.create') }}">Nuevo</a>
                    @endcan
                </div>
                <div class="card-body">
                    <table class="table  table-striped">
                        <tr>
                            <th class="text-center">Nombre</th>
                            @can('Administrador')
                                <th class="text-center" colspan="3">Acciones</th>
                            @endcan
                        </tr>
                        @foreach ($platforms as $platform)
                            <tr>
                                <td>{{ $platform->name }}</td>
                                @can('Administrador')
                                    <td class="text-center" width='10px'>
                                        <a href="{{ route('admin.platforms.show', $platform) }}"><i
                                                class="fas fa-fw fa-regular fa-eye"></i></a>
                                    </td>

                                    <td class="text-center" width='10px'>
                                        <a href="{{ route('admin.platforms.edit', $platform) }}"><i
                                                class="fas fa-fw fa-regular fa-pen"></i></a>
                                    </td>

                                    <td class="text-center" width='10px'>
                                        <form action="{{ route('admin.platforms.destroy', $platform) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('¿Estás seguro de que deseas eliminar esta plataforma ?');"
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
        <h2>A usuario {{ $corto }} no se le ha asignado ningún rol aún.</h2>
    @endcan

@stop

@section('css')
@stop

@section('js')
@stop
