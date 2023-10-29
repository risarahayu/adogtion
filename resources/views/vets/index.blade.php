@extends('layouts.app')

@section('content')
<section>
  <div class="container">
    <div class="d-flex justify-content-between mt-3 mb-5">
      <h1 class="fw-bold">{{ __('Vet List') }}</h1>
      <a href="{{ route('vets.create') }}" class="btn btn-custom-submit my-auto"><i class="bi bi-plus-circle"></i>{{ __('     Add New Vet') }}</a>
      {{-- <div class="input-group mb-3" style="max-width: 300px;">
        <input type="search" class="form-control" placeholder="Search">
        <span class="input-group-text" id="basic-addon2"><i class="bi bi-search"></i></span>
      </div> --}}
    </div>
  </div>
</section>

<section>
  <div class="container">
    <div class="row">
      @foreach ($areas as $area)
      @if ($area->vets()->exists())
        <h4 class="fw-bold border-bottom border-dark pb-2">{{ ucfirst($area->name) }}</h4>
        @foreach($vets->where('area_id', $area->id) as $vet)
          <div class="col-md-4 mb-3">
            <div class="card dog-list @if(!$vet->active) bg-secondary-subtle @endif">
              <h5 class="card-title bold card-header">
                <u><a target="_blank" href="{{ $vet->map_link }}"><i class="bi bi-geo me-3"></i>{{$vet->name}}</a></u>
                <form action="{{ route('vets.activate', $vet->id) }}" method="POST" class="float-end">
                  @csrf
                  @method('PUT')
                  <button class="border border-0 bg-transparent" type="submit"><i class="bi bi-eye-slash"></i></button>
                </form>
              </h5>
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
                    <div class="row">
                      <div class="col-6">
                        <a href="{{ route("vets.edit", ['vet' => $vet->id]) }}" class="btn btn-custom-submit w-100">{{ __('Update') }}</a>
                      </div>
                      <div class="col-6">
                        <button class="btn btn-light w-100 delete-vet">
                          {{ __('Delete') }}
                        </button>
                        <form action="{{ route('vets.destroy', $vet->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      @endif
      @endforeach
    </div>
  </div>
</section>
@endsection

@section('scripts')
  <script>
    $(function() {
      $('.delete-vet').click(function() {
        var self = $(this);
        Swal.fire({
          title: 'Are you sure?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#BD1A8D',
          confirmButtonText: 'Yes',
          cancelButtonText: 'No'
        }).then((result) => {
          if (result.isConfirmed) {
            self.parent().find('form').submit();
          }
        })
      });
    });
  </script>
@endsection