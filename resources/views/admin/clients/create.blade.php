@extends('adminlte::page')

@section('title', 'Admin-index')

@section('content_header')
    @can('admin.users.store')
        <h1>Crear nuevo usuario</h1>
    @else
        @php
            $nombre = auth()->user()->name; // Obtener el nombre del usuario
            $corto = strstr($nombre, ' ', true); // Obtener la parte antes del primer espacio
        @endphp
        <p>Bienvenido {{ $corto }}</p> <!-- Imprimir el valor de $corto correctamente -->
    @endcan
@stop

@section('content')
    <br>
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h5>Dar de alta a un nuevo usuario</h5>
        </div>
        {{ html()->form('POST', route('admin.users.store'))->open() }}
        <div class="card-body">
            <div class="form-group">
                {{ html()->text('name')->class('form-control')->placeholder('Nombre')->required()->attributes(['oninput' => 'this.value = this.value.toUpperCase()']) }}
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                {{ html()->email('email')->class('form-control')->placeholder('Email') }}
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                {{ html()->password('password')->class('form-control')->placeholder('Contraseña') }}
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                {{ html()->password('password_confirmation')->class('form-control')->placeholder('Confirmar Contraseña') }}
                @error('password_confirmation')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="card-footer">
            {{ html()->submit('Grabar')->class('btn btn-primary') }}
            {{ html()->a(route('admin.users.index'), 'Volver')->class('btn btn-success') }}
        </div>
        {{ html()->form()->close() }}
    </div>


@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')

@stop
