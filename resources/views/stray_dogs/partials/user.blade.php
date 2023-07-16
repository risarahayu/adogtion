@php
  $adopter = optional($stray_dog->adoptions()->where('status', 'accepted')->first())->user;
@endphp

<section class="mt-5">
  <div class="container">
    @if (!$stray_dog->adopted)
      <h4 class="fw-bold border-bottom border-dark pb-2 vet-title">
        {{ optional($stray_dog->rescue)->status == 'rescued' ? 'Vets place' : 'Vets near you' }}
        @if (optional($stray_dog->rescue)->status == 'rescuing' && $user->id == optional($stray_dog->rescue)->user_id)
          <small class="fs-6 text-muted">*click rescued button if you already in vet.</small>
        @elseif (optional($stray_dog->rescue)->status == 'rescuing' && $user->id != optional($stray_dog->rescue)->user_id)
          <small class="fs-6 text-muted">*stray dog is rescuing</small>
        @endif
      </h4>
    @endif
    <div class="row">
      @foreach($vets as $vet)
        @php
          $rescue_exists = $stray_dog->rescue()->exists();
          $selected_vet = $rescue_exists && optional($stray_dog->rescue)->vet->id == $vet->id;
        @endphp
        <div class="{{ optional($stray_dog->rescue)->status == 'rescued' ? 'col-md-6' : 'col-md-4' }} mb-3">
          @if ($stray_dog->adopted)
            <h4 class="fw-bold border-bottom border-dark pb-2 vet-title">Vets place</h4>
          @endif
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
                @if ($stray_dog->rescue()->exists())
                  @if ($user->id == optional($stray_dog->rescue)->user_id)
                    <div class="col-12 mt-3 rescue-buttons">
                      @if (optional($stray_dog->rescue)->status != 'rescued')
                        @if ($selected_vet)
                          <div class="row">
                            <div class="col-6">
                              <form class="select-vet" action="{{ route('rescues.update', $stray_dog->rescue->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="rescue_status" value="to_rescued">
                                <button type="button" class="btn btn-custom-submit w-100 btn-rescued">
                                  {{ __('Rescued') }}
                                </button>
                              </form>
                            </div>
                            <div class="col-6">
                              <form class="cancel-vet" action="{{ route('rescues.destroy', $stray_dog->rescue->id) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="button" class="btn btn-light w-100 btn-rescancel">
                                  {{ __('Cancel') }}
                                </button>
                              </form>
                            </div>
                          </div>
                        @else
                          <form class="select-vet" action="{{ route('rescues.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="stray_dog_id" value="{{ $stray_dog->id }}">
                            <input type="hidden" name="vet_id" value="{{ $vet->id }}">
                            <button type="button" class="btn btn-custom-submit w-100 btn-rescue" @if(optional($stray_dog->rescue)->status == 'rescuing') disabled @endif>
                              {{ __('Rescue to vet') }}
                            </button>
                          </form>
                        @endif
                      @else
                        @if ($stray_dog->adoptions->isEmpty())
                          <form class="select-vet" action="{{ route('rescues.update', $stray_dog->rescue->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="rescue_status" value="cancel_rescue">
                            <button type="button" class="btn btn-light w-100 btn-rescued">
                              {{ __('Cancel') }}
                            </button>
                          </form>
                        @endif
                      @endif 
                    </div>
                  @endif
                @else
                  <div class="col-12 mt-3 rescue-buttons">
                    @if (optional($stray_dog->rescue)->status != 'rescued')
                      @if ($selected_vet)
                        <div class="row">
                          <div class="col-6">
                            <form class="select-vet" action="{{ route('rescues.update', $stray_dog->rescue->id) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <input type="hidden" name="rescue_status" value="to_rescued">
                              <button type="button" class="btn btn-custom-submit w-100 btn-rescued">
                                {{ __('Rescued') }}
                              </button>
                            </form>
                          </div>
                          <div class="col-6">
                            <form class="cancel-vet" action="{{ route('rescues.destroy', $stray_dog->rescue->id) }}" method="POST">
                              @csrf
                              @method('delete')
                              <button type="button" class="btn btn-light w-100 btn-rescancel">
                                {{ __('Cancel') }}
                              </button>
                            </form>
                          </div>
                        </div>
                      @else
                        <form class="select-vet" action="{{ route('rescues.store') }}" method="POST">
                          @csrf
                          <input type="hidden" name="stray_dog_id" value="{{ $stray_dog->id }}">
                          <input type="hidden" name="vet_id" value="{{ $vet->id }}">
                          <button type="button" class="btn btn-custom-submit w-100 btn-rescue" @if(optional($stray_dog->rescue)->status == 'rescuing') disabled @endif>
                            {{ __('Rescue to vet') }}
                          </button>
                        </form>
                      @endif
                    @else
                      @if ($stray_dog->adoptions->isEmpty())
                        <form class="select-vet" action="{{ route('rescues.update', $stray_dog->rescue->id) }}" method="POST">
                          @csrf
                          @method('PUT')
                          <input type="hidden" name="rescue_status" value="cancel_rescue">
                          <button type="button" class="btn btn-light w-100 btn-rescued">
                            {{ __('Cancel') }}
                          </button>
                        </form>
                      @endif
                    @endif 
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      @endforeach

      @if ($stray_dog->adopted && optional($adopter)->id == $user->id)
        <div class="col-md-6 mb-3">
          <h4 class="fw-bold border-bottom border-dark pb-2 vet-title">Adopter</h4>
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-6">
                  <div class="d-flex align-items-center" style="gap: 10px">
                    <h4><i class="bi bi-envelope"></i></h4>
                    <div>
                      <small>Email</small>
                      <p class="mb-0">{{ empty($adopter->email) ? "-" : $adopter->email }}</p>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="d-flex align-items-center" style="gap: 10px">
                    <h4><i class="bi bi-facebook"></i></h4>
                    <div>
                      <small>Facebook</small>
                      <p class="mb-0">{{ empty($adopter->userContact->facebook) ? "-" : $adopter->userContact->facebook }}</p>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="d-flex align-items-center" style="gap: 10px">
                    <h4><i class="bi bi-whatsapp"></i></h4>
                    <div>
                      <small>Whatsapp</small>
                      <p class="mb-0">{{ empty($adopter->userContact->whatsapp) ? "-" : $adopter->userContact->whatsapp }}</p>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="d-flex align-items-center" style="gap: 10px">
                    <h4><i class="bi bi-instagram"></i></h4>
                    <div>
                      <small>Instagram</small>
                      <p class="mb-0">{{ empty($adopter->userContact->instagram) ? "-" : $adopter->userContact->instagram }}</p>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="d-flex align-items-center" style="gap: 10px">
                    <h4><i class="bi bi-telegram"></i></h4>
                    <div>
                      <small>Telegram</small>
                      <p class="mb-0">{{ empty($adopter->userContact->telegram) ? "-" : $adopter->userContact->telegram }}</p>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <a class="btn btn-custom-submit w-100" href="{{ route('user_contacts.create') }}">
                    {{ __('Edit Contact') }}
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>
</section>

@if (optional($stray_dog->rescue)->status != 'rescued')
  <section id="section-squad" class="mt-5">
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
@else
  <section>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-6 pt-5">
          @if (!$stray_dog->adoptions->pluck('user_id')->contains($user->id))
            <h4 class="text-center fw-bold">Do you want to adopt this dog?</h4>
          @endif
          <h4 class="pb-2 text-center">
            @if ($stray_dog->adopted)
              {{ optional($adopter)->id == $user->id ? "Congratulations, you have been chosen to adopt this dog! Thank you!" : "Sorry, this dog already adopted" }}
            @else
              We will chat you soon!
            @endif
          </h4>
          @if ($user->adoptions()->where('stray_dog_id', $stray_dog->id)->exists())
            <button type="button" class="btn btn-custom-submit w-100">
              @if ($stray_dog->adopted)
                {{ optional($adopter)->id == $user->id ? "You adopted this dog" : "Your request has been denied" }}
              @else
                {{ __('You already request this dog') }}
              @endif
            </button>
          @else
            <div class="card">
              <div class="card-header">{{ __('Contact') }}</div>
              <div class="card-body">
                <form method="POST" action="{{ route('user_contacts.store') }}" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="stray_dog_id" value="{{ $stray_dog->id }}">
                  
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
                    {{ __('Request adoption') }}
                  </button>
                </form>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </section>
@endif