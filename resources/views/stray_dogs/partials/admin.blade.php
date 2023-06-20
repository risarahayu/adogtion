<section class="mt-5">
  <div class="container">
    @if ($stray_dog->adoptions()->where('status', 'accepted')->exists())
      @php
        $adopter = $stray_dog->adoptions()->where('status', 'accepted')->first()->user;
      @endphp
      <h4 class="fw-bold pb-2">Adopter</h4>
      <div class="row">
        <div class="col-6">
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
                      <p class="mb-0">{{ empty($adopter->userContact->facebook) ? "-" : $adopter->email }}</p>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="d-flex align-items-center" style="gap: 10px">
                    <h4><i class="bi bi-whatsapp"></i></h4>
                    <div>
                      <small>Whatsapp</small>
                      <p class="mb-0">{{ empty($adopter->userContact->whatsapp) ? "-" : $adopter->email }}</p>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="d-flex align-items-center" style="gap: 10px">
                    <h4><i class="bi bi-instagram"></i></h4>
                    <div>
                      <small>Instagram</small>
                      <p class="mb-0">{{ empty($adopter->userContact->instagram) ? "-" : $adopter->email }}</p>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="d-flex align-items-center" style="gap: 10px">
                    <h4><i class="bi bi-telegram"></i></h4>
                    <div>
                      <small>Telegram</small>
                      <p class="mb-0">{{ empty($adopter->userContact->telegram) ? "-" : $adopter->email }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @else
      <table class="table">
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