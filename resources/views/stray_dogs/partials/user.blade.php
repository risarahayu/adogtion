@php
  $adopter = optional($stray_dog->adoptions()->where('status', 'accepted')->first())->user;
@endphp

<section class="mt-5">
  <div class="container">

    @if(optional($stray_dog->rescue)->status == 'rescued')
      <!-- <div style="width:500px; overflow-x:scroll;"> -->
      <img src="{{ asset('images/adoption step finish.svg') }}" class="p-4 d-block m-auto img-fluid" alt="">
      <h6 class="text-center" style="color:#BD1A8D">The dog is ready to adopt</h6>
      <!-- </div> -->
    @else
      <!-- <div style="width:500px; overflow-x:scroll;"> -->
      <img src="{{ asset('images/adoption step.svg') }}" class="p-4 d-block m-auto img-fluid" alt="">
        <h6 class="text-center" style="color:#BD1A8D">To ensure the dog is safe, let's rescue to the vet</h6>
      <!-- </div> -->
    @endif

    <!-- congrats card -->
    @if (optional($stray_dog->rescue)->status == "rescued")
      @if (!$stray_dog->adoptions->pluck('user_id')->contains($user->id) && !$stray_dog->adopted)
        <h4 class="text-center fw-bold">Do you want to adopt this dog?</h4>
      @endif
      <h4 class="pb-2 text-center pt-4">
        @if ($stray_dog->adopted)
          {{ optional($adopter)->id == $user->id ? "Congratulations, you have been chosen to adopt this dog! Thank you!" : "Sorry, this dog already adopted" }}
        @else
          <div class="bar purple">Keep update!</div>
        @endif
      </h4>
      @if ($user->adoptions()->where('stray_dog_id', $stray_dog->id)->exists())
        <div class="d-block m-auto p-3">
          @if ($stray_dog->adopted)
          <div class="bar {{ optional($adopter)->id == $user->id ? 'green' : 'red' }}">
            {{ optional($adopter)->id == $user->id ? "You adopted this dog" : "Your request has been denied" }}
          </div>
          @else
            <div class="text-center fs-4">{{ __('You have already requested this dog, 
               let the rescuer choose the adopter.') }}</div>
          @endif
        </div>
      @elseif(!$stray_dog->adopted )
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
    @endif

    <!-- card -->
    <div class="row my-5">
      @if ($stray_dog->rescue()->exists())
        <div class="col-md-6 mb-3 mb-sm-0">
          <h4 class="fw-bold border-bottom border-dark pb-2 vet-title">Rescuer</h4>
          <div class="card">
            <!-- improve -->
            <h5 class="card-title bold card-header"><i class="bi bi-person-circle me-3"></i>{{$own->name}}</h5>
            <div class="card-body">
              <div class="row">
                <div class="d-flex align-items-center" style="gap: 10px">
                  <h4><i class="bi bi-envelope"></i></h4>
                    <div>
                      <small>Email</small>
                      <p class="mb-0 fw-bold">{{ empty($own->email) ? "-" : $own->email }}</p>
                    </div>
                </div>
                <div class="col-6">
                  <div class="d-flex align-items-center" style="gap: 10px">
                    <h4><i class="bi bi-facebook"></i></h4>
                    <div>
                      <small>Facebook</small>
                      <p class="mb-0 fw-bold">{{ empty($own->userContact->facebook) ? "-" : $own->userContact->facebook }}</p>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="d-flex align-items-center" style="gap: 10px">
                    <h4><i class="bi bi-whatsapp"></i></h4>
                    <div>
                      <small>Whatsapp</small>
                      <p class="mb-0 fw-bold">{{ empty($own->userContact->whatsapp) ? "-" : $own->userContact->whatsapp }}</p>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="d-flex align-items-center" style="gap: 10px">
                    <h4><i class="bi bi-instagram"></i></h4>
                    <div>
                      <small>Instagram</small>
                      <p class="mb-0 fw-bold">{{ empty($own->userContact->instagram) ? "-" : $own->userContact->instagram }}</p>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="d-flex align-items-center" style="gap: 10px">
                    <h4><i class="bi bi-telegram"></i></h4>
                    <div>
                      <small>Telegram</small>
                      <p class="mb-0 fw-bold">{{ empty($own->userContact->telegram) ? "-" : $own->userContact->telegram }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endif
      <div class="col">
        <!-- Adopter -->
        @if ($stray_dog->adopted)
          @php
            $adopter = $stray_dog->adoptions()->where('status', 'accepted')->first()->user;
          @endphp
          <div class="col mb-3">
            <h4 class="fw-bold border-bottom border-dark pb-2 vet-title">Adopter</h4>
            <div class="card">
              <h5 class="card-title bold card-header"><i class="bi bi-person-circle me-3"></i>{{$adopter->name}}</h5>
              <div class="card-body">
                <div class="row">
                  <div class="d-flex align-items-center" style="gap: 10px">
                    <h4><i class="bi bi-envelope"></i></h4>
                      <div>
                        <small>Email</small>
                        <p class="mb-0 fw-bold">{{ empty($adopter->email) ? "-" : $adopter->email }}</p>
                      </div>
                   </div>
                  <div class="col-6">
                    <div class="d-flex align-items-center" style="gap: 10px">
                      <h4><i class="bi bi-facebook"></i></h4>
                      <div>
                        <small>Facebook</small>
                        <p class="mb-0 fw-bold">{{ empty($adopter->userContact->facebook) ? "-" : $adopter->userContact->facebook }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="d-flex align-items-center" style="gap: 10px">
                      <h4><i class="bi bi-whatsapp"></i></h4>
                      <div>
                        <small>Whatsapp</small>
                        <p class="mb-0 fw-bold">{{ empty($adopter->userContact->whatsapp) ? "-" : $adopter->userContact->whatsapp }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="d-flex align-items-center" style="gap: 10px">
                      <h4><i class="bi bi-instagram"></i></h4>
                      <div>
                        <small>Instagram</small>
                        <p class="mb-0 fw-bold">{{ empty($adopter->userContact->instagram) ? "-" : $adopter->userContact->instagram }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="d-flex align-items-center" style="gap: 10px">
                      <h4><i class="bi bi-telegram"></i></h4>
                      <div>
                        <small>Telegram</small>
                        <p class="mb-0 fw-bold">{{ empty($adopter->userContact->telegram) ? "-" : $adopter->userContact->telegram }}</p>
                      </div>
                    </div>
                  </div>
                  @if(Auth::id()==$stray_dog->user_id)
                    <div class="col-6">
                      <form class="cancel-adoption" action="{{ route('adoptions.update', $stray_dog->adoptions()->where('status', 'accepted')->first()) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="adoption_status" value="cancel_adoption">
                        <button type="button" class="btn btn-custom-submit w-100 btn-cancel-adoption">
                          {{ __('Cancel') }}
                        </button>
                      </form>
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        @endif
      </div>
    </div>
    
    <section id="vets place">
      @if (!$stray_dog->adopted)
        <h4 class="fw-bold border-bottom border-dark pb-2 vet-title">
          {{ optional($stray_dog->rescue)->status == 'rescued' ? 'Vets place' : 'Vets near you' }}
          @if (optional($stray_dog->rescue)->status == 'rescuing' && $user->id == optional($stray_dog->rescue)->user_id)
            <small class="fs-6 " style="color:#b41986;">*click rescued button if the dog already in vet.</small>
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
          <div class="{{ optional($stray_dog->rescue)->status == 'rescued' ? 'col-8' : 'col-md-4' }} mb-3">
            @if ($stray_dog->adopted)
              <h4 class="fw-bold border-bottom border-dark pb-2 vet-title">Vets place</h4>
            @endif
            <div class="card dog-list">
              <h5 class="card-title bold card-header"><u><a target="_blank" href="{{ $vet->map_link }}"><i class="bi bi-geo me-3"></i>{{$vet->name}}</a></u></h5>
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
      </section>

      @if ($stray_dog->adoptions && optional($adopter)->id == $user->id && !$stray_dog->adopted)
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
  <!-- <section id="section-squad" class="mt-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 p-5 text-center">
          <p>Mission Paws’ible Pet Taxi can assist in moving the animal to the closest vet or you can rescue by yourself also</p>
            <br>
            <p>Let's order and tell them where you want to rescue the dog</p>
          <a href="https://balibuddies.com/pet-friendly-transport-in-bali-with-grab-pet/" type="button" class="btn btn-custom-submit w-100">
            {{ __('Grab Pets') }}
          </a>
          <div class="dropdown">
            <button class="btn btn-custom-submit w-100 mt-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ __('I need a dog Cacher') }}
            </button>
            <ul class="dropdown-menu w-100">
              <li><a class="dropdown-item" href="https://wa.me/+6289526902626">Whatsapp Surya </a></li>
              <li><a class="dropdown-item" href="https://wa.me/+6281337422297">Whatsapp Nana</a></li>
            </ul>
          </div>
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
  </section> -->
@else
  <section>
    <div class="container">
      <div class="row justify-content-center align-items-center">
        @if ($stray_dog->rescue->user_id == $user->id)
          <div class="col-md-6 p-5 text-center ">
            <h1 class="color-mp">Fundraise</h1>
            <p>Tell your friends and family about this animal and ask for help to cover the medical bills</p>
            <a type="button" class="btn btn-custom-submit w-100" href="https://donorbox.org/mp-help-the-animals-of-bali/fundraiser/new">
              {{ __('Start now') }}
            </a>
          </div>
        @endif
      </div>
    </div>
  </section>
@endif




@if(Auth::id()==$stray_dog->user_id)
<div class="container mt-5">
  <!-- Table request -->
    @if ($stray_dog->adoptions()->exists() && !$stray_dog->adopted)
    <h4 class="fw-bold border-bottom border-dark pb-2 vet-title">Requester</h4>
      <table class="table mt-5">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Whatsapp</th>
            <th>Telegram</th>
            <th>Instagram</th>
            <th>Facebook</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($stray_dog->adoptions as $adoption)
            <tr>
              <td>{{ $adoption->user->name }}</td>
              <td>{{ $adoption->user->email }}</td>
              <td>{{ $adoption->user->userContact->whatsapp }}</td>
              <td>{{ $adoption->user->userContact->telegram }}</td>
              <td>{{ $adoption->user->userContact->instagram }}</td>
              <td>{{ $adoption->user->userContact->facebook }}</td>
              <td>
                <form id="accept-form-{{ $adoption->id }}" action="{{ route('adoptions.update', $adoption->id) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <button type="submit" class="btn btn-custom-submit w-100">
                    {{ __('Accept') }}
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <!-- check if this post(with particular ID) is have requester or not  -->
    @elseif(!$stray_dog->adoptions()->exists())
      <h4 class="fw-bold border-bottom border-dark pb-2 vet-title">Requester</h4>
      <h5>No requester yet</h5>
    @endif
  </div>
@endif