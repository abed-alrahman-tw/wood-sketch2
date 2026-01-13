@extends('admin.layout')

@section('title', 'Edit Service')
@section('heading', 'Edit Service')

@section('content')
    <form class="rounded-lg border border-gray-200 bg-white p-6 shadow" method="POST" action="{{ route('admin.services.update', $service) }}">
        @csrf
        @method('PUT')
        @include('admin.services._form')
    </form>
@endsection
