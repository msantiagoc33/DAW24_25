@extends('adminlte::page')

@section('title', 'Admin-index')

@section('content_header')
    <h1>Asignar un Rol</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    <div class="card">
        {{ html()->form('PUT', route('admin.users.update', $user))->open() }}

        <div class="card-body">
            <div class="mb-3">
                {{ html()->text('name', $user->name)->class('form-control') }}
            </div>
            <div class="mb-3">
                {{ html()->email('email', $user->email)->class('form-control') }}
            </div>

            <div class="card-footer">
                <h5>Listado de Roles disponible.</h5>

                @foreach ($roles as $rol)
                    <div class="form-check">
                        <div>
                            <label>
                                {{ html()->checkbox('roles[]', in_array($rol->id, $user->roles->pluck('id')->toArray()))->value($rol->id)->class('mr-1') }}
                                {{ $rol->name }}
                            </label>
                        </div>
                    </div>
                @endforeach
                <div class="mt-4">
                    {{ html()->submit('Actualizar')->class('btn btn-primary btn-sm') }}
                    {{ html()->a(route('admin.users.index'), 'Volver')->class('btn btn-success btn-sm') }}
                </div>
            </div>

            <div class="card-footer">
                <h5>Listado de Permisos disponible.</h5>
                <ol>
                    @foreach ($permisos as $permiso)
                        <li>
                            <div>
                                <label>
                                    {{ html()->text()->value($permiso->name)->class('form-control') }}
                                </label>
                            </div>
                        </li>
                    @endforeach
                </ol>
                <div class="mt-4">
                    {{ html()->submit('Actualizar')->class('btn btn-primary btn-sm') }}
                    {{ html()->a(route('admin.users.index'), 'Volver')->class('btn btn-success btn-sm') }}
                </div>
            </div>
        </div>
        {{ html()->form()->close() }}
    </div>


@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script></script>
@stop
