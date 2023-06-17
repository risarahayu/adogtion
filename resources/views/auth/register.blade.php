@extends('layouts.auth')

@section('content')
<section id="auth-section">
  <div class="container d-flex justify-content-center align-items-center">
    <div class="row justify-content-center align-items-center">
      <div class="col-lg-6">
        <img class="img-fluid" src="{{ asset('images/mp_logo_big.svg') }}" alt="Example Image">
      </div>
      <div class="col-lg-6">
        <h2 class="text-center mb-4 fw-bold">EVERY RESCUE MISSION IS POSSIBLE WHERE WE WORK TOGETHER!</h2>
        <div class="auth-form">
          <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">{{ __('Name') }}</label>
              <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
              @error('name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">{{ __('Email Address') }}</label>
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

              @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">{{ __('Password') }}</label>
              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
              @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>

            <div class="mb-3">
              <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>

            <div class="row mt-5 align-items-center">
              <div class="col-md-6">
                <button type="submit" class="btn btn-light btn-auth-submit">
                  {{ __('Register') }}
                </button>
              </div>
              <div class="col-md-6">
                <a class="btn" href="{{ route('login') }}">
                  {{ __('Already have account') }}
                </a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
