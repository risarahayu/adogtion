@extends('layouts.app')

@section('content')

<section>
  <div class="container">
    <div class="d-flex justify-content-between mt-3 mb-5">
    <div>
      <h1 class="fw-bold">{{ __('Stray Dog List') }}</h1>
        <p>We found <span class="fw-semibold">{{$stray_dogs->count()}} 
            at
            @if(!empty($area_name))
              {{$area_name}}
            @else
              <span>All</span>
            
            @endif
          </span> stray dog</p>
      </div>
      <form action="/search" method="GET" class="input-group mb-3" style="max-width: 300px; height:fit-content;" >
        @csrf <!-- Add CSRF token -->
        <input type="search" name="search" class="form-control" placeholder="Search" >
        <span class="input-group-text" id="basic-addon2"><i class="bi bi-search"></i></span>
      </form>
      <div>
      <!-- sort -->
      <div class="dropdown"> 
            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-filter me-2"></i>Filter
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{ route('home') }}">All</a></li>
              <li><a class="dropdown-item" href="{{ route('home.sort', ['status' => 'unrescued']) }}">Unrescue</a></li>
              <li><a class="dropdown-item" href="{{ route('home.sort', ['status' => 'rescued']) }}">Rescue</a></li>
              <li><a class="dropdown-item" href="{{ route('home.sort', ['status' => 'adopted']) }}">Adopted</a></li>
            </ul>
          </div>
      </div>
    </div>
  </div>
</section>


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
