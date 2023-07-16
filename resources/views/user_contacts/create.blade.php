@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-6">
      <div class="card">
        <div class="card-header">{{ __('Contact') }}</div>
        <div class="card-body">
          <form method="POST" action="{{ route('user_contacts.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
              <label for="whatsapp" class="col-md-4 col-form-label">{{ __('Whatsapp') }}</label>
              <div class="col-md-8">
                <input id="whatsapp" type="number" class="form-control @error('whatsapp') is-invalid @enderror" name="whatsapp" required autocomplete="whatsapp" value="{{ optional($user->userContact)->whatsapp }}">
                @error('whatsapp')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
      
            <div class="row mb-3">
              <label for="telegram" class="col-md-4 col-form-label">{{ __('Telegram') }}</label>
              <div class="col-md-8">
                <input id="telegram" type="number" class="form-control @error('telegram') is-invalid @enderror" name="telegram" autocomplete="telegram" value="{{ optional($user->userContact)->telegram }}">
                @error('telegram')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
      
            <div class="row mb-3">
              <label for="instagram" class="col-md-4 col-form-label">{{ __('Instagram') }}</label>
              <div class="col-md-8">
                <input id="instagram" type="text" class="form-control @error('instagram') is-invalid @enderror" name="instagram" autocomplete="instagram" value="{{ optional($user->userContact)->instagram }}">
                @error('instagram')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
      
            <div class="row mb-3">
              <label for="facebook" class="col-md-4 col-form-label">{{ __('Facebook') }}</label>
              <div class="col-md-8">
                <input id="facebook" type="text" class="form-control @error('facebook') is-invalid @enderror" name="facebook" autocomplete="facebook" value="{{ optional($user->userContact)->facebook }}">
                @error('facebook')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
      
            <button type="submit" class="btn btn-custom-submit w-100">
              {{ __('Update contact') }}
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection