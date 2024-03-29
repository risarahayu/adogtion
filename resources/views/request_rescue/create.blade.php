@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center flex-column-reverse flex-lg-row">
    <div class="col-lg-6">
      <div class="d-flex align-items-center h-100">
        <div class="card w-100">
          <div class="card-header">{{ __('Request Rescue') }}</div>
  
          <div class="card-body">
            <form method="POST" action="{{ route('request_rescue.store') }}" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="user_id" value="{{ $user->id }}">
              <input type="hidden" name="area" class="selected-kecamatan">
              <input type="hidden" name="map_link" class="map-link">
  
              <fieldset id="fieldset-dog" class="d-block">
                <div class="row mb-3">
                  <label for="dog_type" class="col-md-4 col-form-label">{{ __('Dog Type') }}</label>
                  <div class="col-md-8">
                    <input id="dog_type" type="text" class="form-control required @error('dog_type') is-invalid @enderror" name="dog_type" placeholder="Example Bali Street Dog, Kintamani Dog" required autocomplete="dog_type">
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
                    <input id="color" type="text" class="form-control required @error('color') is-invalid @enderror" placeholder="Example black, brown, white"  name="color" required autocomplete="color">
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
                    <input id="temperament" type="text" class="form-control required @error('temperament') is-invalid @enderror" name="temperament" placeholder="Example friendly, protective"  required autocomplete="temperament">
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
                    <select class="form-select required select2 @error('area_id') is-invalid @enderror" name="gender">
                      <option value="">Choose dog's gender</option>
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
                    <select class="form-select required select2 @error('size') is-invalid @enderror" name="size">
                      <option value="">Choose dog's size</option>
                      <option value="Small >10kg">Small >10kg</option>
                      <option value="Medium 11-15kg">Medium 11-15kg</option>
                      <option value="Large 16-20kg">Large 16-20kg</option>
                      <option value="Extra Large 20+kg">Extra Large 20+kg</option>
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
                    <textarea class="form-control required @error('description') is-invalid @enderror" placeholder="Tell us about the dog condition ..."  id="description" name="description" required autocomplete="description"></textarea>
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
                    <input id="images" type="file" class="form-control required @error('images') is-invalid @enderror" name="images[]" required autocomplete="images" multiple>
                    @error('images')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>

                  <div class="col-md-12 mt-3">
                    <div class="image-preview p-3 w-100 border d-none">
                      <div id="new-images" class="position-relative mb-3 d-none">
                        <button type="button" id="delete-new-image" class="btn-delete-images btn btn-danger">Delete</button>
                        <p class="fw-bold">New picture</p>
                        <div class="images-wrapper row row-cols-3">
                          {{-- WILL ADD NEW IMAGE HERE USING JS --}}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
  
                <button type="button" id="fake-submit" class="btn btn-custom-submit w-100">
                  {{ __('Submit') }}
                </button>
              </fieldset>
  
              <!-- AREA -->
              <fieldset id="fieldset-area" class="d-none">
                
                <div class="row mb-3">
                  <label for="area" class="col-md-4 col-form-label">{{ __('Current Area') }}</label>
                  
                   
                  
                  <div class="col-md-8">
                  <!-- <label for="areaDropdown" class="form-label">Select Area</label> -->
                    <select class="form-select" id="areaDropdown" name="area">
                        <option value="" selected disabled>Select an area</option>
                        @foreach($areas as $area)
                            <option value="{{ $area->id }}">{{ $area->name }}</option>
                        @endforeach
                    </select>
                    <!-- <input class="form-control selected-kecamatan" type="text" name="area"> -->
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

    <div class="col-lg-6">
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
      // FAKE SUBMIT
      $('#fake-submit').click(function() {
        // VARIABLE DEFINITION
        var validateFields = $('.required');
        var allFieldsFilled = validateFields.filter(function() {
          return $(this).val() === '';
        }).length === 0;

        validateFields.each(function() {
          if ($(this).val() === '') {
            $(this).addClass('is-invalid');
          } else {
            $(this).removeClass('is-invalid');
          }
        });

        validateFields.keyup(function() {
          if ($(this).val() === '') {
            $(this).addClass('is-invalid');
          } else {
            $(this).removeClass('is-invalid');
          };
        });
        
        if (allFieldsFilled) {
          console.log('Semua field telah diisi.');
          $('#fieldset-dog').toggleClass('d-block d-none');
          $('#fieldset-area').toggleClass('d-none d-block');
        } else {
          console.log('Ada field yang belum diisi.');
        }
      });

      // IMAGES
      // Fungsi ini akan dipanggil ketika tombol "Delete Old Image" diklik
      $('#delete-old-image').on('click', function () {
        // Sembunyikan #old-images
        $('#old-images').remove();
        // Atur nilai #delete_image menjadi true
        $('#delete_image').val('1');

        if ($('#old-images').length == 0 && $("#images").val() == '') {
          $(".image-preview").addClass("d-none")
          $("#images").addClass("required");
        } else {
          $(".image-preview").removeClass("d-none")
        }
      });

      // Fungsi ini akan dipanggil ketika tombol "Delete New Image" diklik
      $('#delete-new-image').on('click', function () {
        // Kosongkan nilai dari input file #images
        $('#images').val('');
        // Sembunyikan #new-images
        $('#new-images').addClass('d-none');

        if ($('#old-images').length == 0) {
          $(".image-preview").addClass("d-none")
          $("#images").addClass("required");
        } else {
          $(".image-preview").removeClass("d-none")
        }
      });

      $('#images').on('change', function (e) {
        // Kosongkan #new-images
        $('#new-images .images-wrapper').empty();
        
        // Loop melalui file yang dipilih
        $.each(this.files, function (index, file) {
          // Buat elemen gambar baru
          var img = $('<img/>', {
            class: 'preview-image',
            alt: 'Image Preview',
          });

          // Buat objek URL untuk file yang dipilih
          var imgURL = URL.createObjectURL(file);

          // Atur sumber gambar ke URL objek yang dibuat
          img.attr('src', imgURL);

          // Tambahkan gambar ke #new-images
          $('#new-images .images-wrapper').append(img);
        });

        // Tampilkan #new-images jika ada gambar yang dipilih
        if (this.files.length > 0) {
          $('#new-images').removeClass('d-none');
          $("#images").removeClass("required");
          $(".image-preview").removeClass("d-none")
        } else {
          $('#new-images').addClass('d-none');
          $(".image-preview").addClass("d-none")
        }
      });
    });
  </script>
@endsection
