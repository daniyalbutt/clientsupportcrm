@extends('layouts.app-front')

@section('content')

<!-- Breadcrumb Section Begin -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="#"><i class="fa fa-home"></i> Home</a>
                    <span>Registration</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Form Section Begin -->
<!-- Register Section Begin -->
<div class="register-login-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="register-form">
                    <h2>Registration</h2>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <!-- 0 for buyer -->
                        <input type="hidden" value="0" name="is_employee">

                        <div class="group-input">
                            <label for="username">{{ __('E-Mail Address') }} *</label>
                            <input type="email" id="username" name="email" class="form-control @error('email') is-invalid @enderror"  value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="group-input">
                            <label for="fname">First Name *</label>
                            <input type="text" id="fname" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autocomplete="name" >
                            @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="group-input">
                            <label for="lname">Last Name *</label>
                            <input type="text" id="username" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" required autocomplete="last_name">
                            @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="group-input">
                            <label for="con">Contact *</label>
                            <input type="text" id="con" name="contact" class="form-control @error('contact') is-invalid @enderror" value="{{ old('contact') }}" required autocomplete="contact">
                            @error('contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="group-input">
                            <label for="pass"  >Password *</label>
                            <input id="pass" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">

                            @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="group-input">
                            <label for="con-pass" >Confirm Password *</label>
                            <input id="con-pass" type="password" name="password_confirmation" class="form-control"  required autocomplete="new-password">
                        </div>
                        <button type="submit" class="site-btn register-btn" >REGISTER</button>
                    </form>
                    <div class="switch-login">
                        <a href="{{ route('login') }}" class="or-login">Or Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Register Form Section End -->
@endsection
