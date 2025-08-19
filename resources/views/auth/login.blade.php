@extends('layouts.app-front')
@section('title', 'Login')
@section('content')
<div class="auth-layout-wrap">
    <div class="auth-content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card o-hidden">
                    <div class="p-5">
                        <div class="auth-logo text-center mb-4">
                            <img src="{{ asset('global/img/logo.png') }}" alt="{{ config('app.name') }}">
                        </div>
                        <h1 class="mb-3 text-18">Sign In</h1>
                        <form class="form-horizontal form-simple"  action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control form-control-rounded @error('email') is-invalid @enderror" name="email" id="email" placeholder="Your Email" required  value="{{ old('email') }}" autofocus>
                                @if (\Session::has('error'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{!! \Session::get('error') !!}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control form-control-rounded @error('password') is-invalid @enderror" id="password" placeholder="Enter Password" required autocomplete="current-password">
                            </div>
                            <button class="btn btn-rounded btn-primary btn-block mt-2" type="submit">Sign In</button>
                        </form>
                        <div class="mt-3 text-center">
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-muted">
                                <u>Forgot Password?</u>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
