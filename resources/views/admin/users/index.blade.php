@extends('adminlte::page')

@section('title', 'Users-index')

@section('content_header')

@stop

@section('content')
    <br>
    @can('Administrador')
        @livewire('admin.users-index')
    @else
        @include('admin.index');
    @endcan
@stop

@section('css')
@stop

@section('js')

@stop
