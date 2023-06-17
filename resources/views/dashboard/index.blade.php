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
              <span class="h1 m-0 fw-bold">12</span>
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
              <span class="h1 m-0 fw-bold">12</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="mb-5">
  <div class="container">
    <h4 class="fw-bold border-bottom border-dark pb-2">Dog you post</h4>
    <a href="{{ route("stray_dogs.create") }}" style="text-decoration: none">
      <div class="card dashboard-nodata-card">
        <div class="card-body text-muted d-flex justify-content-center align-items-center flex-column">
          <h4 class="m-0">No post yet</h4>
          <h1><i class="bi bi-plus-square-dotted me-3"></i>Add new stray dog</h1>
        </div>
      </div>
    </a>
  </div>
</section>

<section class="mb-5">
  <div class="container">
    <h4 class="fw-bold border-bottom border-dark pb-2">Dog you request</h4>
    <a href="{{ route("stray_dogs.index") }}" style="text-decoration: none">
      <div class="card dashboard-nodata-card">
        <div class="card-body text-muted d-flex justify-content-center align-items-center flex-column">
          <h4 class="m-0">No request yet</h4>
          <h1><i class="bi bi-plus-square-dotted me-3"></i>View all dogs</h1>
        </div>
      </div>
    </a>
  </div>
</section>
@endsection
