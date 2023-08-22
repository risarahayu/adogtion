@extends('layouts.app')

@section('content')
<div class="container">
  <div class="card mb-5">
    <div class="card-body">
      <input id="addressInput" type="text" placeholder="Enter an address" class="form-control">
      <div id="map" style="width: 100%; height: 500px;"></div>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">{{ __('Vets') }}</div>

        <div class="card-body">
          <form method="POST" action="{{ route('vets.store') }}">
            @csrf
            <input type="hidden" name="area" class="selected-kecamatan">
            <input type="hidden" name="map_link" class="map-link">

            <div class="row mb-3">
              <label for="area" class="col-md-4 col-form-label">{{ __('Area') }}</label>

              <div class="col-md-8">
                <input class="form-control selected-kecamatan" type="text" disabled>
                {{-- <select class="form-select area-select2 @error('area') is-invalid @enderror" name="area">
                  @foreach($areas as $area)
                    <option value="{{ $area->name }}">{{ $area->name }}</option>
                  @endforeach
                </select> --}}

                @error('area')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <label for="name" class="col-md-4 col-form-label">{{ __('Name') }}</label>

              <div class="col-md-8">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required autocomplete="name">

                @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            
            <div class="row mb-3">
              <label for="telephone" class="col-md-4 col-form-label">{{ __('Telephone') }}</label>

              <div class="col-md-8">
                <input id="telephone" type="tel" class="form-control @error('telephone') is-invalid @enderror" name="telephone" required autocomplete="telephone">

                @error('telephone')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <label for="whatsapp" class="col-md-4 col-form-label">{{ __('whatsapp') }}</label>

              <div class="col-md-8">
                <input id="whatsapp" type="tel" class="form-control @error('whatsapp') is-invalid @enderror" name="whatsapp" required autocomplete="whatsapp">

                @error('whatsapp')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-md-4 col-form-label">{{ __('Schedule') }}</label>
              <div class="col-md-8">
                <select class="form-select" id="schedule_template">
                  <option>{{--Select schedule template--}}</option>
                  <option value="all">All day</option>
                  <option value="working">Working Day</option>
                  <option value="custom">Custom</option>
                </select> 
              </div>
            </div>

            <div id="schedule_table" class="card mb-3">
              <div class="card-body">
                <table class="table">
                  <thead>
                    <tr style="font-size: 12px">
                      <th></th>
                      <th>Day</th>
                      <th>Open Hour</th>
                      <th>Close Hour</th>
                      <th>Fullday</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <div class="form-check d-flex justify-content-center">
                          <input id="days_used" class="form-check-input" type="checkbox">
                        </div>
                      </td>
                      <td>
                        Default
                        <a type="button" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="left" data-bs-content="Left popover">
                          <i class="bi bi-question-circle-fill"></i>
                        </a>
                      </td>
                      <td>
                        <input id="open_hours" type="time" class="form-control">
                      </td>
                      <td>
                        <input id="close_hours" type="time" class="form-control">
                      </td>
                      <td>
                        <div class="form-check d-flex justify-content-center">
                          <input id="fulldays" class="form-check-input" type="checkbox">
                        </div>
                      </td>
                    </tr>
                    @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                    <tr>
                      <td>
                        <div class="form-check d-flex justify-content-center">
                          <input name="schedule[{{ $day }}][open_day]" class="form-check-input day-used {{ $day }}" type="checkbox">
                        </div>
                      </td>
                      <td>
                        {{ ucfirst($day) }}
                        <input type="hidden" name="schedule[{{ $day }}][day_name]" value="{{ $day }}">
                      </td>
                      <td>
                        <input id="open_hour_{{ $day }}" type="time" class="form-control open-hour @error('schedule.'.$day.'.open_hour') is-invalid @enderror" name="schedule[{{ $day }}][open_hour]" value="{{ old('schedule.'.$day.'.open_hour') }}" autocomplete="off">
                        @error('schedule.'.$day.'.open_hour')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      </td>
                      <td>
                        <input id="close_hour_{{ $day }}" type="time" class="form-control close-hour @error('schedule.'.$day.'.close_hour') is-invalid @enderror" name="schedule[{{ $day }}][close_hour]" value="{{ old('schedule.'.$day.'.close_hour') }}" autocomplete="off">
                        @error('schedule.'.$day.'.close_hour')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      </td>
                      <td>
                        <div class="form-check d-flex justify-content-center">
                          <input class="form-check-input fullday" type="checkbox" name="schedule[{{ $day }}][fullday]" id="fullday_{{ $day }}" {{ old('schedule.'.$day.'.fullday') ? 'checked' : '' }}>
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>

            <button type="submit" class="btn btn-custom-submit w-100">
              {{ __('Submit') }}
            </button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="h-100 d-flex align-items-center p-5">
        <img class="img-fluid" src="{{ asset('images/new-dog.svg') }}" alt="Example Image">
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
  <script>
    $(function() {
      // Tabel Schedule
      // SCHEDULE TEMPLATE CHANGES
      $('#schedule_template').change(function() {
        if (!$(this).val() == '') {
          $('#schedule_table').addClass('active');
          $('.day-used').prop('checked', false);
          $('.day-used').not(':checked').parents('tr').find('td').css('opacity', '1');
          $('.day-used').not(':checked').parents('tr').find('td input').prop('disabled', false);
          if ($(this).val() == 'all') {
            $('.day-used, #days_used').prop('checked', true);
          } else if ($(this).val() == 'working') {
            $('#days_used').prop('checked', false);
            $('.day-used').not('.saturday, .sunday').prop('checked', true);
          } else if ($(this).val() == 'custom') {
            // do something later maybe
          };
          $('.day-used').not(':checked').parents('tr').find('td').not(':first-child').css('opacity', '0.5');
          $('.day-used').not(':checked').parents('tr').find('td:not(:first-child) input').prop('disabled', true);
        } else {
          $('#schedule_table').removeClass('active');
        };
      });

      // WHEN OPEN DAY IS CHECKED
      $('.day-used').click(function() {
        if ($(this).is(':checked')) {
          $(this).parents('tr').find('td').css('opacity', '1');
          $(this).parents('tr').find('td input').prop('disabled', false);
          $(this).parents('tr').find('input.open-hour').val($('#open_hours').val());
          $(this).parents('tr').find('input.close-hour').val($('#close_hours').val());
        } else {
          $(this).parents('tr').find('td').not(':first-child').css('opacity', '0.5');
          $(this).parents('tr').find('td:not(:first-child) input').prop('disabled', true);
          $(this).parents('tr').find('input.open-hour').val('');
          $(this).parents('tr').find('input.close-hour').val('');
        };

        var allday = $('.day-used').length === $('.day-used:checked').length;
        var working_day = $('.day-used:checked').length === 5 && 
                          $('.day-used.saturday:not(:checked), .day-used.sunday:not(:checked)').length === 2;

        if (allday) {
          $('#schedule_template').val('all');
        } else if (working_day) {
          $('#schedule_template').val('working');
        } else {
          $('#schedule_template').val('custom');
        }
      });

      // WHEN DEFAULT SCHEDULE IS CHANGE
      $('#days_used').click(function() {
        if ($(this).is(':checked')) {
          $('.day-used:not(:checked)').click();
        } else {
          $('.day-used:checked').click();
        };
      });

      // open and close hour change
      $('#open_hours, #close_hours').change(function() {
        if ($(this).is('#open_hours')) {
          $('.open-hour:not(:disabled)').val($(this).val());
        } else if ($(this).is('#close_hours')) {
          $('.close-hour:not(:disabled)').val($(this).val());
        };
      });

      // fullday change
      $('#fulldays').click(function() {
        if ($(this).is(':checked')) {
          $('.fullday:not(:disabled)').prop('checked', true);
        } else {
          $('.fullday:checked').prop('checked', false);
        };
      });
    });
  </script>
@endsection