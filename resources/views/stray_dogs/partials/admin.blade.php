<section class="mt-5">
  <div class="container">
    @if (!$stray_dog->adopted)
      <h4 class="fw-bold border-bottom border-dark pb-2 vet-title">Vets place</h4>
    @endif
    <div class="row">
      <!-- VET -->
      @if (optional($stray_dog->rescue)->status == 'rescued')  
        @foreach($vets as $vet)
          <div class="col-md-6 mb-3">
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
                </div>
              </div>
            </div>
          </div>
        @endforeach
      @endif

      <!-- Adopter -->
      @if ($stray_dog->adopted)
        @php
          $adopter = $stray_dog->adoptions()->where('status', 'accepted')->first()->user;
        @endphp
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
                  <form class="cancel-adoption" action="{{ route('adoptions.update', $stray_dog->adoptions()->where('status', 'accepted')->first()) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="adoption_status" value="cancel_adoption">
                    <button type="button" class="btn btn-custom-submit w-100 btn-cancel-adoption">
                      {{ __('Cancel') }}
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endif
    </div>

    <!-- Table request -->
    @if (!$stray_dog->adopted)
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
    @endif
  </div>
</section>