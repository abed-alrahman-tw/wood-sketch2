@extends('admin.layout')

@section('title', 'Admin Login')
@section('heading', 'Admin Login')

@section('content')
    <form method="post" action="{{ route('admin.login.store') }}">
        @csrf

        <div>
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password">Password</label>
            <input id="password" name="password" type="password" required>
            @error('password')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label>
                <input type="checkbox" name="remember">
                Remember me
            </label>
        </div>

        <button type="submit">Sign in</button>
    </form>
@endsection
