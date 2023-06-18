@extends('layouts.auth')

@section('title', 'Adogtion - Login')

@section('content')
<section id="auth-section">
  <div class="container d-flex justify-content-center align-items-center">
    <div class="row justify-content-center align-items-center">
      <div class="col-lg-6">
        <img class="img-fluid" src="{{ asset('images/mp_logo_big.svg') }}">
      </div>
      <div class="col-lg-6">  
        <h2 class="text-center mb-4 fw-bold">EVERY RESCUE MISSION IS POSSIBLE WHERE WE WORK TOGETHER!</h2>
        <div class="auth-form">
          <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-2">
              <label for="email" class="form-label">{{ __('Email Address') }}</label>
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
              @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
  
            <div class="mb-2">
              <label for="password" class="form-label">{{ __('Password') }}</label>
              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
              @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
  
            {{-- <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
  
                <label class="form-check-label" for="remember">
                  {{ __('Remember Me') }}
                </label>
              </div>
            </div> --}}
  
            <div class="row mt-5">
              <div class="col-md-6">
                <button type="submit" class="btn btn-light btn-auth-submit">
                  {{ __('Login') }}
                </button>
              </div>
              <div class="col-md-6">
                <a class="btn" href="{{ route('register') }}">
                  {{ __('Create account') }}
                </a>
              </div>
            </div>
            
            {{-- <div class="text-center">
              @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                  {{ __('Forgot Your Password?') }}
                </a>
              @endif
            </div> --}}
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
