@extends('layouts.auth')

@section('content')
<div class="container" style="height: 100vh;">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-md-5">
            <div class="logo-brand text-center mb-5">
                <img src="{{ asset('img/logo.svg') }}" width="285" style="object-fit: cover;">
            </div>
            <div class="card p-4">
                <div class="card-header mb-4 h4 ps-0">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" class="w-100">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="group-box">
                                <span class="icon">
                                    <i data-feather="mail"></i>
                                </span>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off" autofocus>
                            </div>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="group-box">
                                <span class="icon">
                                    <i data-feather="lock"></i>
                                </span>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            </div>

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>

                        <div class="mb-0">
                            <button type="submit" class="btn btn-primary w-100">
                                {{ __('Login') }}
                            </button>

                            <!-- @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
