@extends('layouts.app')

@section('content')
  <section>
    <div class="container">
      <div class="row">
        <div class="col-md-6 dog-show">
          <div class="row">
            <div class="col-6">
              <div class="d-flex align-items-center" style="gap: 15px;">
                <img class="dtl-icon" src="{{ asset('images/dog-type.png') }}">
                <div>
                  <small>Dog Type</small><br/>
                  <h4 class="fw-bold">{{ ucfirst($stray_dog->dog_type) }}</h4>
                </div>
              </div>
            </div>

            <div class="col-6">
              <div class="d-flex align-items-center" style="gap: 15px;">
                <i class="bi bi-gender-ambiguous dtl-icon"></i>
                <div>
                  <small>Gender</small><br/>
                  <h4 class="fw-bold">{{ ucfirst($stray_dog->gender) }}</h4>
                </div>
              </div>
            </div>

            <div class="col-6">
              <div class="d-flex align-items-center" style="gap: 15px;">
                <i class="bi bi-palette2 dtl-icon"></i>
                <div>
                  <small>Color(s)</small><br/>
                  <h4 class="fw-bold">{{ ucfirst($stray_dog->color) }}</h4>
                </div>
              </div>
            </div>

            <div class="col-6">
              <div class="d-flex align-items-center" style="gap: 15px;">
                <img class="dtl-icon" src="{{ asset('images/cil_animal.png') }}">
                <div>
                  <small>Size</small><br/>
                  <h4 class="fw-bold">{{ ucfirst($stray_dog->size) }}</h4>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="d-flex align-items-center" style="gap: 15px;">
                <i class="bi bi-file-earmark-text dtl-icon"></i>
                <div>
                  <small>Description</small><br/>
                  <h4 class="fw-bold">{{ ucfirst($stray_dog->description) }}</h4>
                </div>
              </div>
            </div>
          </div>

          <div id="carouselExampleIndicators" class="carousel slide mt-5" data-bs-ride="true">
            <div class="carousel-indicators">
              @foreach ($stray_dog->images as $index => $image)
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $index }}" class="@if($index === 0) active @endif" aria-current="true" aria-label="Slide {{ $index }}"></button>
              @endforeach
            </div>
            <div class="carousel-inner">
              @foreach ($stray_dog->images as $index => $image)
                <div class="carousel-item @if($index === 0) active @endif">
                  <div class="dog-picture mx-auto">
                    <img class="rounded" src="{{ asset($image->filename) }}">
                  </div>
                </div>
              @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
        <div class="col-md-6 p-5">
          <img class="img-fluid" src="{{ asset('images/lets-chat-withus.svg') }}">
        </div>
      </div>
    </div>
  </section>

  <section class="mt-5">
    <div class="container">
      <h4 class="fw-bold border-bottom border-dark pb-2">Vets near you</h4>
      <div class="row">
        @foreach($vets as $vet)
          <div class="col-md-4 mb-3">
            <div class="card dog-list">
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <div class="d-flex align-items-center" style="gap: 15px;">
                      <i class="bi bi-calendar-event dtl-icon"></i>
                      <div>
                        <small>Available on</small><br/>
                        @php
                          $abbreviations = $vet->schedules->pluck('day_name')->map(function ($day) {
                            return substr($day, 0, 3);
                          });
                        @endphp
                        <p class="fw-bold mb-0">{{ $abbreviations->implode(', ') }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="d-flex align-items-center" style="gap: 15px;">
                      <i class="bi bi-clock dtl-icon"></i>
                      <div>
                        <small>At</small><br/>
                        @php
                          $openCloseHours = $vet->schedules->map(function ($schedule) {
                            return [
                              'open_hour' => substr($schedule->open_hour, 0, 5),
                              'close_hour' => substr($schedule->close_hour, 0, 5),
                            ];
                          });
                          $maxHour = $openCloseHours->max();
                          $startTime = $maxHour['open_hour'];
                          $endTime = $maxHour['close_hour'];
                        @endphp
                        <p class="fw-bold mb-0">{{ $startTime }} - {{ $endTime }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="d-flex align-items-center" style="gap: 15px;">
                      <i class="bi bi-geo-alt dtl-icon"></i>
                      <div>
                        <small>Area</small><br/>
                        <p class="fw-bold mb-0">{{ $vet->area->name }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="d-flex align-items-center" style="gap: 15px;">
                      <i class="bi bi-whatsapp dtl-icon"></i>
                      <div>
                        <small>Whatsapp</small><br/>
                        <p class="fw-bold mb-0">{{ $vet->whatsapp }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="d-flex align-items-center" style="gap: 15px;">
                      <i class="bi bi-telephone dtl-icon"></i>
                      <div>
                        <small>Telephone</small><br/>
                        <p class="fw-bold mb-0">{{ $vet->telephone }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 mt-3">
                    <button type="button" class="btn btn-custom-submit w-100">
                      {{ __('Rescue to vet') }}
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <section class="mt-5">
    <div class="container">
      <div class="row">
        <div class="col-6 p-5 text-center">
          <h1 class="color-mp">Scooter Squad</h1>
          <p>Mission Paws’ible Pet Taxi can assist in moving the animal to the closest vet</p>
          <button type="button" class="btn btn-custom-submit w-100">
            {{ __('Book now') }}
          </button>
        </div>
        
        <div class="col-6 p-5 text-center">
          <h1 class="color-mp">Fundraise</h1>
          <p>Tell your friends and family about this animal and ask for help to cover the medical bills</p>
          <button type="button" class="btn btn-custom-submit w-100">
            {{ __('Start now') }}
          </button>
        </div>
      </div>
    </div>
  </section>
@endsection