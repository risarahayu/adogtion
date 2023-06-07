@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('Vets') }}</div>

        <div class="card-body">
          <form method="POST" action="{{ route('vets.store') }}">
            @csrf

            <div class="row mb-3">
              <label for="area" class="col-md-4 col-form-label text-md-end">{{ __('Area') }}</label>

              <div class="col-md-6">
                <select class="form-select area-select2 @error('area') is-invalid @enderror" name="area">
                  @foreach($areas as $area)
                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                  @endforeach
                </select>

                @error('area')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

              <div class="col-md-6">
                <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" required autocomplete="name">

                @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            
            <div class="row mb-3">
              <label for="telephone" class="col-md-4 col-form-label text-md-end">{{ __('Telephone') }}</label>

              <div class="col-md-6">
                <input id="telephone" type="telephone" class="form-control @error('telephone') is-invalid @enderror" name="telephone" required autocomplete="telephone">

                @error('telephone')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <label for="whatsapp" class="col-md-4 col-form-label text-md-end">{{ __('whatsapp') }}</label>

              <div class="col-md-6">
                <input id="whatsapp" type="whatsapp" class="form-control @error('whatsapp') is-invalid @enderror" name="whatsapp" required autocomplete="whatsapp">

                @error('whatsapp')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <label for="day_open" class="col-md-4 col-form-label text-md-end">{{ __('day_open') }}</label>

              <div class="col-md-6">
                <input id="day_open" type="day_open" class="form-control @error('day_open') is-invalid @enderror" name="day_open" required autocomplete="day_open">

                @error('day_open')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <label for="day_close" class="col-md-4 col-form-label text-md-end">{{ __('day_close') }}</label>

              <div class="col-md-6">
                <input id="day_close" type="day_close" class="form-control @error('day_close') is-invalid @enderror" name="day_close" required autocomplete="day_close">

                @error('day_close')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <label for="hour_open" class="col-md-4 col-form-label text-md-end">{{ __('hour_open') }}</label>

              <div class="col-md-6">
                <input id="hour_open" type="hour_open" class="form-control @error('hour_open') is-invalid @enderror" name="hour_open" required autocomplete="hour_open">

                @error('hour_open')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <label for="hour_close" class="col-md-4 col-form-label text-md-end">{{ __('hour_close') }}</label>

              <div class="col-md-6">
                <input id="hour_close" type="hour_close" class="form-control @error('hour_close') is-invalid @enderror" name="hour_close" required autocomplete="hour_close">

                @error('hour_close')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6 offset-md-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="fullday" id="fullday" {{ old('fullday') ? 'checked' : '' }}>

                  <label class="form-check-label" for="fullday">
                    {{ __('Fullday') }}
                  </label>
                </div>
              </div>
            </div>

            <div class="row mb-0">
              <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  {{ __('Submit') }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection