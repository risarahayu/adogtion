@extends('layouts.app')

@section('content')
<div class="container">
  @foreach($stray_dogs as $stray_dog)
    <div>
      <h2>{{ $stray_dog->name }}</h2>
      <p>Description: {{ $stray_dog->description }}</p>

      @foreach($stray_dog->images as $image)
        <img class="img-fluid" src="{{ asset($image->filename) }}" alt="Stray Dog Image">
      @endforeach
    </div>
  @endforeach
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('Dashboard') }}</div>

        <div class="card-body">
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
          @endif

          {{ __('You are logged in!') }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection