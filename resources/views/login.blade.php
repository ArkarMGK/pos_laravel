@extends('layouts.master')
@section('title', 'Login')
@section('content')
    <div class="login-form mt-4">
        @error('terms')
            <small class="text-danger">{{ $message }}</small>
        @enderror
        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="form-group mt-4">
                <label>Email Address</label>
                <input class="au-input au-input--full" type="email" name="email" placeholder="Email">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mt-4">
                <label>Password</label>
                <input class="au-input au-input--full" type="password" name="password" placeholder="Password">
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mt-4">
                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">sign in</button>
            </div>

        </form>
        <div class="register-link mt-4">
            <p>
                Don't you have account?
                <a href="{{ url('registerPage') }}">Sign Up Here</a>
            </p>
        </div>
    </div>
@endsection
