@extends('adminlte::page')

{{-- Vista para la edición de un usuario --}}
@section('title', 'Users-edit')

@section('content_header')

@stop

@section('content')

    @can('Administrador')
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
            <!-- Mostrar el mensaje de éxito -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <!-- Mostrar el mensaje de éxito -->
            @if (session('info'))
                <div class="alert alert-success">
                    <strong>{{ session('info') }}</strong>
                </div>
            @endif
            <!-- Mostrar el mensaje de error -->
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <div class="card">
            <div class="card-header bg-azul-claro text-center text-white fs-1">
                Modificar usuario {{ $user->name }}
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
        {{-- Mostrar una vista con un mensaje que informa al usuario que no tiene acceso --}}
        @include('admin.index');
    @endcan


@stop

@section('css')

@stop

@section('js')

@stop
