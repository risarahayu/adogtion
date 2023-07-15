@extends('layouts.app')

@section('content')
<section class="mb-5">
  <div class="container">
    <div class="row justify-content-around">
      <div class="col-lg-5 col-xl-4">
        <div class="card">
          <div class="card-body d-flex justify-content-center py-4" style="gap: 20px;">
            <img class="img-fluid" src="{{ asset('images/dog-post.svg') }}" alt="Example Image">
            <div class="fw-bold text-center d-flex justify-content-center flex-column">
              Dog Post<br />
              @php
                $dog_posts = $stray_dogs->where('user_id', $user->id);
              @endphp
              <span class="h1 m-0 fw-bold">{{ $dog_posts->count() }}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-5 col-xl-4">
        <div class="card">
          <div class="card-body d-flex justify-content-center py-4" style="gap: 20px;">
            <img class="img-fluid" src="{{ asset('images/dog-request.svg') }}" alt="Example Image">
            <div class="fw-bold text-center d-flex justify-content-center flex-column">
              Dog Request<br />
              @php
                $dog_requests = $user->administrator ? 
                  $stray_dogs->filter(function ($stray_dog) { return $stray_dog->adoptions()->exists() && $stray_dog->adopted === 0; }) : 
                  $stray_dogs->filter(function ($stray_dog) use ($user) { return $stray_dog->adopted === 0 && $stray_dog->adoptions()->where('user_id', $user->id)->exists(); });
              @endphp
              <span class="h1 m-0 fw-bold">{{ $dog_requests->count() }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@if($user->administrator)
  @include('dashboard.partials.admin')
@else
  @include('dashboard.partials.user')
@endif

@endsection
