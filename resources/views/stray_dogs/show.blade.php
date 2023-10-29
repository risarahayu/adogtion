@extends('layouts.app')

@section('content')
  <section>
    <div class="container">
      <div class="row flex-md-row flex-column-reverse">
        <div class="col-md-6 dog-show">
          <div class="row">
            <div class="col-6">
              <div class="d-flex align-items-center" style="gap: 15px;">
                <img class="dtl-icon" src="{{ asset('images/dog-type.png') }}">
                <div>
                  <small>Dog Type</small><br/>
                  <h4 class="fw-bold">{{ ucfirst($stray_dog->dog_type) }}</h4>
                </div>
              </div>
            </div>

            <div class="col-6">
              <div class="d-flex align-items-center" style="gap: 15px;">
                <i class="bi bi-gender-ambiguous dtl-icon"></i>
                <div>
                  <small>Gender</small><br/>
                  <h4 class="fw-bold">{{ ucfirst($stray_dog->gender) }}</h4>
                </div>
              </div>
            </div>

            <div class="col-6">
              <div class="d-flex align-items-center" style="gap: 15px;">
                <i class="bi bi-palette2 dtl-icon"></i>
                <div>
                  <small>Color(s)</small><br/>
                  <h4 class="fw-bold">{{ ucfirst($stray_dog->color) }}</h4>
                </div>
              </div>
            </div>

            <div class="col-6">
              <div class="d-flex align-items-center" style="gap: 15px;">
                <img class="dtl-icon" src="{{ asset('images/cil_animal.png') }}">
                <div>
                  <small>Size</small><br/>
                  <h4 class="fw-bold">{{ ucfirst($stray_dog->size) }}</h4>
                </div>
              </div>
            </div>

            <div class="col-6">
              <div class="d-flex align-items-center" style="gap: 15px;">
                <i class="bi bi-file-earmark-text dtl-icon"></i>
                <div>
                  <small>Description</small><br/>
                  <h4 class="fw-bold">{{ ucfirst($stray_dog->description) }}</h4>
                </div>
              </div>
            </div>
            
            <div class="col-6">
              <div class="d-flex align-items-center" style="gap: 15px;">
                <i class="bi bi-whatsapp dtl-icon"></i>
                <div>
                  
                  <a href="{{route('user_contacts.show', $own->id) }}"><small>By {{ $own->name }}</small></a><br/>
                  <h4 class="fw-bold">{{ optional($own->userContact)->whatsapp }}</h4>
                </div>
              </div>
            </div>
          </div>

          <div id="carouselExampleIndicators" class="carousel slide mt-5" data-bs-ride="true">
            <div class="carousel-indicators">
              @foreach ($stray_dog->images as $index => $image)
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $index }}" class="@if($index === 0) active @endif" aria-current="true" aria-label="Slide {{ $index }}"></button>
              @endforeach
            </div>
            <div class="carousel-inner">
              @foreach ($stray_dog->images as $index => $image)
                <div class="carousel-item @if($index === 0) active @endif">
                  <div class="dog-picture mx-auto">
                    <img class="rounded" src="{{ asset($image->filename) }}">
                  </div>
                </div>
              @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
        <div class="col-md-6 text-center">
          @if(Auth::id()==$stray_dog->user_id)
            <div class="mb-5 d-flex justify-content-end" style="gap: 5px;">
              <a type="button" class="btn btn-custom-submit" href="{{ route('stray_dogs.edit', $stray_dog->id) }}"><i class="bi bi-pencil-square me-2"></i>edit</a>
              @if (!$stray_dog->rescue()->exists())
                <button class="btn btn-danger delete-dog">
                  <i class="bi bi-trash me-2"></i>delete
                </button>
                <form action="{{ route('stray_dogs.destroy', $stray_dog->id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                </form>
              @endif
            </div>
          @endif
          <img class="img-fluid p-5 d-none d-md-block" src="{{ asset('images/lets-chat-withus.svg') }}">
        </div>
      </div>
    </div>
  </section>

  @if(auth()->user()->administrator)
    @include('stray_dogs.partials.admin')
  @else
    @include('stray_dogs.partials.user')
  @endif
@endsection

@section('scripts')
  <script>
    $(function() {
      // Rescuing button
      $('.btn-rescue').click(function() {
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
            self.parents('form.select-vet').submit();
          }
        })
      });
      
      // Rescued button
      $('.btn-rescued').click(function() {
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
            // Arahkan pengguna ke section dengan ID target
            // var targetSectionId = 'section-squad';
            // $('#' + targetSectionId).get(0).scrollIntoView({ behavior: 'smooth' });
            self.parents('form.select-vet').submit();
          }
        })
      });
      
      // Cancel resque
      $('.btn-rescancel').click(function() {
        var self = $(this);
        Swal.fire({
          title: 'Are you sure?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#BD1A8D',
          confirmButtonText: 'Yes',
          cancelButtonText: 'No'
        }).then((result) => {
          self.parents('form.cancel-vet').submit();
        })
      });

      // Cancel resque
      $('.btn-cancel-adoption').click(function() {
        var self = $(this);
        Swal.fire({
          title: 'Are you sure?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#BD1A8D',
          confirmButtonText: 'Yes',
          cancelButtonText: 'No'
        }).then((result) => {
          self.parents('form.cancel-adoption').submit();
        })
      });

      $('.delete-dog').click(function() {
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