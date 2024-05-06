@extends('layouts.guest')

@section('title', 'Register')

@section('content')

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="single-form-input">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus>
            <x-input_error field="name"></x-input_error>
        </div>

        <div class="single-form-input">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
            <x-input_error field="email"></x-input_error>
        </div>

        <div class="single-form-input">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <x-input_error field="password"></x-input_error>
        </div>

        <div class="single-form-input">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            <x-input_error field="password_confirmation"></x-input_error>
        </div>

        <div class="single-form-input flex items-center justify-end mb-0">
            <a href="{{ route('login') }}">Already registered?</a>

            <button type="submit" class="submit-button ml-3">REGISTER</button>
        </div>
    </form>

@endsection