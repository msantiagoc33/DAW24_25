@extends('adminlte::page')

@section('title', 'Admin-index')

@section('content_header')
    <h1>Ficha del usuario</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body bg-slate-400">
            <h2>{{ $user->name }}</h2>
            <h3>{{ $user->email }}</h3>
        </div>
        <div class="card-footer">
            {{ html()->a(route('admin.users.index'), 'Volver')->class('btn btn-success btn-sm') }}
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script></script>
@stop
