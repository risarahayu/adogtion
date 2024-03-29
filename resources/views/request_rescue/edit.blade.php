@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="d-flex align-items-center h-100">
        <div class="card w-100">
          <div class="card-header">{{ __('Edit Stray Dog') }}</div>

          <div class="card-body">
            <form method="POST" action="{{ route('request_rescue.update', $strayDog->id) }}" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <input type="hidden" name="user_id" value="{{ $user->id }}">
              <input type="hidden" name="area" class="selected-kecamatan">
              <input type="hidden" name="map_link" class="map-link">
              <input type="hidden" name="delete_image" id="delete_image" value="0">
  
              <fieldset id="fieldset-dog" class="d-block">
                <div class="row mb-3">
                  <label for="dog_type" class="col-md-4 col-form-label">{{ __('Dog Type') }}</label>
                  <div class="col-md-8">
                    <input id="dog_type" value="{{ $strayDog->dog_type }}" type="text" class="form-control required @error('dog_type') is-invalid @enderror" name="dog_type" required autocomplete="dog_type">
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
                    <input id="color" value="{{ $strayDog->color }}" type="text" class="form-control required @error('color') is-invalid @enderror" name="color" required autocomplete="color">
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
                    <input id="temperament" value="{{ $strayDog->temperament }}" type="text" class="form-control required @error('temperament') is-invalid @enderror" name="temperament" required autocomplete="temperament">
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
                    <select class="form-select required select2 @error('size') is-invalid @enderror" name="size">
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
                    <textarea class="form-control required @error('description') is-invalid @enderror" id="description" name="description" required autocomplete="description">{{ $strayDog->description }}</textarea>
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

                  <div class="col-md-12 mt-3">
                    <div class="image-preview p-3 w-100 border">
                      <div id="old-images" class="position-relative mb-3">
                        <button type="button" id="delete-old-image" class="btn-delete-images btn btn-danger">Delete</button>
                        <p class="fw-bold">Old picture</p>
                        <div class="row row-cols-3">
                          @foreach ($images as $image)
                            <div class="col mt-3">
                              <img src="{{$image->filename}}" class="preview-image" alt="Image Preview">
                            </div>
                          @endforeach
                        </div>
                      </div>

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

                {{-- <button type="submit" class="btn btn-custom-submit w-100">
                  {{ __('Submit') }}
                </button> --}}
                <button type="button" id="fake-submit" class="btn btn-custom-submit w-100">
                  {{ __('Submit') }}
                </button>
              </fieldset>

              <!-- AREA -->
              <fieldset id="fieldset-area" class="d-none">
                <div class="row mb-3">
                  <label for="area" class="col-md-4 col-form-label">{{ __('Area') }}</label>
    
                  <div class="col-md-8">
                    <input class="form-control selected-kecamatan" type="text" name="area" value="{{ $strayDog->area->name }}">
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

  {{-- <!-- image -->
  <script>
    $(function() {
      const imageInput = document.getElementById('images');
      const previewImage = document.getElementById('preview-image');
      const deleteButton = document.getElementById('delete-image');

      // Listen for changes in the input field
      imageInput.addEventListener('change', function () {
        const file = imageInput.files[0];

        if (file) {
          const reader = new FileReader();
          reader.onload = function (e) {
            previewImage.src = e.target.result;
            previewImage.style.display = 'block';
            deleteButton.style.display = 'block';
          };
          reader.readAsDataURL(file);
        } else {
          previewImage.src = '';
          previewImage.style.display = 'none';
          deleteButton.style.display = 'none';
        }
      });

      // Add click event listener to delete button
      deleteButton.addEventListener('click', function () {
        imageInput.value = '';
        previewImage.src = '';
        previewImage.style.display = 'none';
        deleteButton.style.display = 'none';
        $("#images").addClass("required");
      });
    });
  </script> --}}
@endsection
