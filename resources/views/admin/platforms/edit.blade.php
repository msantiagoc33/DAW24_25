@extends('adminlte::page')

@section('title', 'Platform-edit')

@section('content_header')

@stop

@section('content')
    @can('Administrador')
        @if (session('info'))
            <div class="alert alert-success">
                <strong>{{ session('info') }}</strong>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h2>Modificar una plataforma</h2>
            </div>

            <form action="{{ route('admin.platforms.update', $platform->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" value="{{ old('name', $platform->name) }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                        <a href="{{ route('admin.platforms.index') }}" class="btn btn-secondary btn-sm">Volver</a>
                    </div>
                </div>

            </form>
        </div>
    @else
        @php
            $nombre = auth()->user()->name; // Obtener el nombre del usuario
            $corto = strstr($nombre, ' ', true); // Obtener la parte antes del primer espacio
        @endphp
        <h2>{{ $corto }} no tiene permisos para modificar plataformas.</h2>
    @endcan
@stop

@section('css')
@stop

@section('js')
    <script></script>
@stop
