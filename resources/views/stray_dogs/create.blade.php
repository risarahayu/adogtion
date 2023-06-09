@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="d-flex align-items-center h-100">
        <div class="card w-100">
          <div class="card-header">{{ __('Stray Dog') }}</div>
  
          <div class="card-body">
            <form method="POST" action="{{ route('stray_dogs.store') }}" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="user_id" value="{{ $user->id }}">
  
              <fieldset id="fieldset-dog" class="d-block">
                <div class="row mb-3">
                  <label for="dog_type" class="col-md-4 col-form-label">{{ __('Dog Type') }}</label>
                  <div class="col-md-8">
                    <input id="dog_type" type="text" class="form-control @error('dog_type') is-invalid @enderror" name="dog_type" required autocomplete="dog_type">
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
                    <input id="color" type="text" class="form-control @error('color') is-invalid @enderror" name="color" required autocomplete="color">
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
                    <input id="temperament" type="text" class="form-control @error('temperament') is-invalid @enderror" name="temperament" required autocomplete="temperament">
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
                      <option></option>
                      <option value="male">{{ __('Male') }}</option>
                      <option value="female">{{ __('Female') }}</option>
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
                    <input id="size" type="text" class="form-control @error('size') is-invalid @enderror" name="size" required autocomplete="size">
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
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" required autocomplete="description"></textarea>
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
                    <input id="images" type="file" class="form-control @error('images') is-invalid @enderror" name="images[]" required autocomplete="images" multiple>
                    @error('images')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
  
                <button type="button" id="fake-submit" class="btn btn-custom-submit w-100">
                  {{ __('Submit') }}
                </button>
              </fieldset>
  
              <!-- AREA -->
              <fieldset id="fieldset-area" class="d-none">
                <div class="row mb-3">
                  <label for="map_link" class="col-md-4 col-form-label">{{ __('Map Link') }}</label>
                  <div class="col-md-8">
                    <input id="map_link" type="text" class="form-control @error('map_link') is-invalid @enderror" name="map_link" required autocomplete="map_link">
                    @error('map_link')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="area_id" class="col-md-4 col-form-label">{{ __('Area') }}</label>
                  <div class="col-md-8">
                    <select class="form-select select2 @error('area_id') is-invalid @enderror" name="area_id">
                      @foreach($areas as $area)
                        <option value="{{ $area->id }}">{{ $area->name }}</option>
                      @endforeach
                    </select>
                    @error('area_id')
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
        var validateFields = $('.form-control, .form-select').not("[type='file'], [name='area_id'], [name='map_link']")
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