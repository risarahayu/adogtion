<section class="mt-5">
  <div class="container">
    <div class="row my-5">
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

      <!-- vets place -->
      @if ($stray_dog->adopted && $stray_dog->rescue()->where('status', 'rescued'))
        @php
          $vet_rescue=$stray_dog->rescue;
        @endphp
        <div class="col-md-8">
          <h4 class="fw-bold border-bottom border-dark pb-2 vet-title">Vets place</h4>
          <div class="card dog-list">
            <div class="card-body">
              <div class="row">
                <div class="col-8">
                  <div class="d-flex align-items-center" style="gap: 15px;">
                    <i class="bi bi-calendar-event dtl-icon"></i>
                    <div>
                      <small>Available on</small><br/>
                      @php
                        $abbreviations = $vet_rescue->vet->schedules->pluck('day_name')->map(function ($day) {
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
                        $openCloseHours = $vet_rescue->vet->schedules->map(function ($schedule) {
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
                      <p class="fw-bold mb-0">{{ $vet_rescue->vet->area->name }}</p>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="d-flex align-items-center" style="gap: 15px;">
                    <i class="bi bi-whatsapp dtl-icon"></i>
                    <div>
                      <small>Whatsapp</small><br/>
                      <p class="fw-bold mb-0">{{ $vet_rescue->vet->whatsapp }}</p>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="d-flex align-items-center" style="gap: 15px;">
                    <i class="bi bi-telephone dtl-icon"></i>
                    <div>
                      <small>Telephone</small><br/>
                      <p class="fw-bold mb-0">{{ $vet_rescue->vet->telephone }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endif

    </div>
  </div>
    <!-- Table request -->
    @if(!$stray_dog->adopted)
      <div class="container">
        <h4 class="fw-bold border-bottom border-dark pb-2 vet-title">Requester</h4>
        @if($stray_dog->adoptions)
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
                    @if(Auth::id()==$stray_dog->user_id)
                      <form id="accept-form-{{ $adoption->id }}" action="{{ route('adoptions.update', $adoption->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-custom-submit w-100">
                          {{ __('Accept') }}
                        </button>
                      </form>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @elseif(!$stray_dog->adoptions)
        
          <h5>No requester yet</h5>
        
        @endif
      </div>
    @endif
  </div>
</section>