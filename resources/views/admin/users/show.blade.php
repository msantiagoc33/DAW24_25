@extends('adminlte::page')

@section('title', 'Admin-index')

@section('content_header')

@stop

@section('content')
    @can('Administrador')
        <div class="card">
            <div class="card-header bg-slate-600">
                <h1>Ficha del usuario</h1>
            </div>

            <div class="card-body bg-slate-400">
                <h2>{{ $user->name }}</h2>
                <h3>{{ $user->email }}</h3>
            </div>
            <hr>
            <ul>
                <h5>Roles asignados</h5>
                @foreach ($roles as $rol)
                    <div class="form-check">
                        <div>
                            <label>
                                <input type="checkbox" name="roles[]" value="{{ $rol->id }}" class="mr-1"
                                    {{ in_array($rol->id, $user->roles->pluck('id')->toArray()) ? 'checked' : '' }} disabled>
                                {{ $rol->name }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </ul>

            <div class="card-footer text-right">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">Volver</a>
            </div>
        </div>
    @else
        @php
            $nombre = auth()->user()->name; // Obtener el nombre del usuario
            $corto = strstr($nombre, ' ', true); // Obtener la parte antes del primer espacio
        @endphp
        <h2>{{ $corto }} no tiene permisos para ver ficha de usuarios.</h2>
    @endcan
@stop

@section('css')

@stop

@section('js')
    <script></script>
@stop
