@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="d-flex align-items-center h-100">
        <div class="card w-100">
          <div class="card-header">{{ __('Edit Stray Dog') }}</div>

          <div class="card-body">
            <form method="POST" action="{{ route('stray_dogs.update', $strayDog->id) }}" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <input type="hidden" name="user_id" value="{{ $user->id }}">
              <input type="hidden" name="area" class="selected-kecamatan">
              <input type="hidden" name="map_link" class="map-link">
  
              <fieldset id="fieldset-dog" class="d-block">
                <div class="row mb-3">
                  <label for="dog_type" class="col-md-4 col-form-label">{{ __('Dog Type') }}</label>
                  <div class="col-md-8">
                    <input id="dog_type" value="{{ $strayDog->dog_type }}" type="text" class="form-control @error('dog_type') is-invalid @enderror" name="dog_type" required autocomplete="dog_type">
                    @error('dog_type')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
                
                <div class="row mb-3">
                  <label for="color" class="col-md-4 col-form-label">{{ __('Color') }}</label>
                  <div class="col-md-8">
                    <input id="color" value="{{ $strayDog->color }}" type="text" class="form-control @error('color') is-invalid @enderror" name="color" required autocomplete="color">
                    @error('color')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="temperament" class="col-md-4 col-form-label">{{ __('Temperament') }}</label>
                  <div class="col-md-8">
                    <input id="temperament" value="{{ $strayDog->temperament }}" type="text" class="form-control @error('temperament') is-invalid @enderror" name="temperament" required autocomplete="temperament">
                    @error('temperament')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="gender" class="col-md-4 col-form-label">{{ __('Gender') }}</label>
                  <div class="col-md-8">
                    <select class="form-select select2 @error('area_id') is-invalid @enderror" name="gender">
                      <option value=""></option>
                      <option value="male" {{ $strayDog->gender === 'male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                      <option value="female" {{ $strayDog->gender === 'female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                    </select>
                    @error('gender')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="size" class="col-md-4 col-form-label">{{ __('Size') }}</label>
                  <div class="col-md-8">
                    <select class="form-select select2 @error('size') is-invalid @enderror" name="size">
                      <option value=""></option>
                      <option value="Small >10kg" {{ $strayDog->size === 'Small >10kg' ? 'selected' : '' }}>Small >10kg</option>
                      <option value="Medium 11-15kg" {{ $strayDog->size === 'Medium 11-15kg' ? 'selected' : '' }}>Medium 11-15kg</option>
                      <option value="Large 16-20kg" {{ $strayDog->size === 'Large 16-20kg' ? 'selected' : '' }}>Large 16-20kg</option>
                      <option value="Extra Large 20+kg" {{ $strayDog->size === 'Extra Large 20+kg' ? 'selected' : '' }}>Extra Large 20+kg</option>
                    </select>

                    @error('size')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="description" class="col-md-4 col-form-label">{{ __('Description') }}</label>
                  <div class="col-md-8">
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" required autocomplete="description">{{ $strayDog->description }}</textarea>
                    @error('description')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="images" class="col-md-4 col-form-label">{{ __('Pictures') }}</label>
                  <div class="col-md-8">
                    <input id="images" type="file" class="form-control @error('images') is-invalid @enderror" name="images[]" autocomplete="images" multiple>
                    @error('images')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>

                {{-- <button type="submit" class="btn btn-custom-submit w-100">
                  {{ __('Submit') }}
                </button> --}}
                <button type="button" id="fake-submit" class="btn btn-custom-submit w-100">
                  {{ __('Submit') }}
                </button>
              </fieldset>

              <!-- AREA -->
              <fieldset id="fieldset-area" class="d-none">
                <div class="google-map mb-3">
                  <input id="addressInput" type="text" placeholder="Enter your current address" class="form-control">
                  <div id="map" style="width: 100%; height: 500px;"></div>
                </div>
                <div class="row mb-3">
                  <label for="area" class="col-md-4 col-form-label">{{ __('Area') }}</label>
    
                  <div class="col-md-8">
                    <input class="form-control selected-kecamatan" type="text" disabled>
                    @error('area')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
                <button type="submit" class="btn btn-custom-submit w-100">
                  {{ __('Submit') }}
                </button>
              </fieldset>
            </form>
          </div>
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
      $('#fake-submit').click(function() {
        var validateFields = $('.form-control, .form-select').not("[name='area_id'], [name='map_link'], #addressInput")
        var allFieldsFilled = validateFields.filter(function() {
          return $(this).val() === '';
        }).length === 0;
        validateFields.each(function() {
          $('.form-control, .form-select').keyup(function() {
            if ($(this).val() === '') {
              $(this).addClass('is-invalid');
            } else {
              $(this).removeClass('is-invalid');
            };
          });
          if ($(this).val() === '') {
            $(this).addClass('is-invalid');
          } else {
            $(this).removeClass('is-invalid');
          }
        });
        if (allFieldsFilled) {
          console.log('Semua field telah diisi.');
          $('#fieldset-dog').toggleClass('d-block d-none');
          $('#fieldset-area').toggleClass('d-none d-block');
        } else {
          console.log('Ada field yang belum diisi.');
        }
      });
    });
  </script>
@endsection
