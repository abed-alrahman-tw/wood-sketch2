@extends('admin.layout')

@section('title', 'New Category')
@section('heading', 'Create Category')

@section('content')
    <form class="rounded-lg border border-gray-200 bg-white p-6 shadow" method="POST" action="{{ route('admin.categories.store') }}">
        @csrf
        @include('admin.categories._form')
    </form>
@endsection
