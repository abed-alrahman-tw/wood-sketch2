@extends('admin.layout')

@section('title', 'Edit Category')
@section('heading', 'Edit Category')

@section('content')
    <form class="rounded-lg border border-gray-200 bg-white p-6 shadow" method="POST" action="{{ route('admin.categories.update', $category) }}">
        @csrf
        @method('PUT')
        @include('admin.categories._form')
    </form>
@endsection
