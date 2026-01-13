@extends('admin.layout')

@section('title', 'New Project')
@section('heading', 'Create Project')

@section('content')
    <form class="rounded-lg border border-gray-200 bg-white p-6 shadow" method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.projects._form')
    </form>
@endsection
