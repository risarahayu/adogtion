@extends('layouts.app')

@section('content')
<section>
  <div class="container">
    <div class="d-flex justify-content-between mt-3 mb-5">
      <h1 class="fw-bold">{{ __('Stray Dog List') }}</h1>
      <div class="input-group mb-3" style="max-width: 300px;">
        <input type="search" class="form-control" placeholder="Search">
        <span class="input-group-text" id="basic-addon2"><i class="bi bi-search"></i></span>
      </div>
    </div>
  </div>
</section>

<section>
  <div class="container">
    <div class="row">
      @if ($stray_dogs->isNotEmpty())        
        @foreach($stray_dogs as $stray_dog)
          <div class="col-md-4 mb-3">
            <a href="{{ route("stray_dogs.show", ['stray_dog' => $stray_dog->id]) }}">
              <div class="card dog-list">
                <div class="card-body">
                  <div class="row mb-3">
                    <div class="col-5">
                      <div class="dog-picture">
                        <img class="rounded" src="{{ asset($stray_dog->images->first()->filename) }}" alt="Stray Dog Image">
                      </div>
                    </div>
                    <div class="col-7 d-flex flex-column justify-content-center">
                      <div class="d-flex align-items-center" style="gap: 15px;">
                        <i class="bi bi-gender-ambiguous dtl-icon"></i>
                        <div>
                          <small>Gender</small><br/>
                          <h4 class="fw-bold">{{ ucfirst($stray_dog->gender) }}</h4>
                        </div>
                      </div>
                      <div class="d-flex align-items-center" style="gap: 15px;">
                        <img class="dtl-icon" src="{{ asset('images/cil_animal.png') }}">
                        <div>
                          <small>Size</small><br/>
                          <h4 class="fw-bold">{{ ucfirst($stray_dog->size) }}</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row adoption-status">
                    <div class="col-5 d-flex align-items-center">
                      @php
                        if($stray_dog->rescue()->exists()) {
                          $dog_status = ucfirst($stray_dog->rescue->status);
                          $status_style = "";
                        } else {
                          $dog_status = 'Unrescued';
                          $status_style = "background-color: orangered;";
                        };
                      @endphp
                      <button type="button" class="btn btn-custom-submit w-100" style="{{ $status_style }}">
                        {{ $dog_status }}
                      </button>
                    </div>
                    <div class="col-7">
                      <small class="fw-bold">Request by 3 peoples</small><br/>
                      <small>Since {{ $stray_dog->created_at->format('Y-m-d') }}</small>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>
        @endforeach
      @else
        <a href="{{ route("stray_dogs.create") }}" style="text-decoration: none">
          <div class="card dashboard-nodata-card">
            <div class="card-body text-muted d-flex justify-content-center align-items-center flex-column">
              <h4 class="m-0">No stray dog yet</h4>
              <h1><i class="bi bi-plus-square-dotted me-3"></i>Register stray dog you found</h1>
            </div>
          </div>
        </a>
      @endif
    </div>
  </div>
</section>
@endsection