@extends('adminlte::page')

@section('title', 'Admin-index')

@section('content_header')
    @can('Administrador')
        <h1>Modificar usuario y asignar roles.</h1>
    @endcan
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    @can('Administrador')
        <div class="card">
            <div class="card-header">
                <h5>Modificar usuario {{ $user->name }}</h5>
            </div>
            <form action="{{ route('admin.users.update', $user->id) }}" method="post">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                            oninput="this.value = this.value.toUpperCase()">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="text" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <h5>Listado de Roles disponibles y asignados.</h5>

                    @foreach ($roles as $rol)
                        <div class="form-check">
                            <div>
                                <label>
                                    <input type="checkbox" name="roles[]" value="{{ $rol->id }}" class="mr-1"
                                        {{ in_array($rol->id, $user->roles->pluck('id')->toArray()) ? 'checked' : '' }}>
                                    {{ $rol->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                    {{-- </div> --}}
                    <div class="card-footer">
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">Volver</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @else
        @php
            $nombre = auth()->user()->name; // Obtener el nombre del usuario
            $corto = strstr($nombre, ' ', true); // Obtener la parte antes del primer espacio
        @endphp
        <h2>{{ $corto }} no tiene permisos para crear editar usuarios.</h2>
    @endcan


@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script></script>
@stop
