@extends('admin.layout')

@section('title', 'Edit Project')
@section('heading', 'Edit Project')

@section('content')
    <form class="rounded-lg border border-gray-200 bg-white p-6 shadow" method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.projects._form')
    </form>
@endsection
