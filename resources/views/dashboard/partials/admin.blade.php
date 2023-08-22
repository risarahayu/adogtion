<section class="mb-5">
  <div class="container">
    <h4 class="fw-bold border-bottom border-dark pb-2">Dog have request</h4>
    @if (!$dog_requests->isNotEmpty())
      <a href="{{ route("stray_dogs.index") }}" style="text-decoration: none">
        <div class="card dashboard-nodata-card">
          <div class="card-body text-muted d-flex justify-content-center align-items-center flex-column">
            <h4 class="m-0">No request yet</h4>
            <h1><i class="bi bi-plus-square-dotted me-3"></i>See all dogs</h1>
          </div>
        </div>
      </a>
    @else
      <div class="row">
        @foreach ($dog_requests as $stray_dog)
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
                      <button type="button" class="btn btn-custom-submit w-100">
                        @if($stray_dog->rescue()->exists())
                          {{ ucfirst($stray_dog->rescue->status) }}
                        @else
                          {{ __('Unrescued') }}
                        @endif
                      </button>
                    </div>
                    <div class="col-7">
                      <small class="fw-bold">Request by 3 peoples</small><br/>
                      <small>Since 12-12-2022</small>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</section>