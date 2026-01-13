@extends('admin.layout')

@section('title', 'New Service')
@section('heading', 'Create Service')

@section('content')
    <form class="rounded-lg border border-gray-200 bg-white p-6 shadow" method="POST" action="{{ route('admin.services.store') }}">
        @csrf
        @include('admin.services._form')
    </form>
@endsection
