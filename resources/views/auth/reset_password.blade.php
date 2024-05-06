@extends('layouts.guest')

@section('title', 'Reset Password')

@section('content')

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="single-form-input">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $request->email) }}" required autofocus>
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
            <button type="submit" class="submit-button ml-3">RESET PASSWORD</button>
        </div>
    </form>

@endsection