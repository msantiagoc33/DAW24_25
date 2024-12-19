@extends('adminlte::page')

{{-- Vista para mostrar la ficha de un usuario --}}
@section('title', 'Users-show')

@section('content_header')

@stop

@section('content')
    {{-- Esta vista sólo la puede ver el Administrador --}}
    @can('Administrador')
        <div class="card">
            <div class="card-header bg-azul-claro text-center text-white fs-1">
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
        {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
        @include('admin.index');
    @endcan
@stop

@section('css')

@stop

@section('js')

@stop
