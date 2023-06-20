@extends('layouts.app')

@section('content')
  <section>
    <div class="container">
      <div class="row">
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

            <div class="col-12">
              <div class="d-flex align-items-center" style="gap: 15px;">
                <i class="bi bi-file-earmark-text dtl-icon"></i>
                <div>
                  <small>Description</small><br/>
                  <h4 class="fw-bold">{{ ucfirst($stray_dog->description) }}</h4>
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
        <div class="col-md-6 p-5">
          <img class="img-fluid" src="{{ asset('images/lets-chat-withus.svg') }}">
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
            $.ajax({
              url: "{{ route('rescues.store') }}",
              method: "POST",
              data: {
                stray_dog_id: self.data('dog-id'),
                vet_id: self.data('vet-id')
              },
              success: function(response) {
                // Tangani respon sukses
                console.log(response.rescue_id);
                $(".btn-rescue").not(self).prop('disabled', true);
                self.parent().addClass('d-none');
                self.parents('.rescue-buttons').find('.rescuing-btns').toggleClass('d-none', 'd-block');
                self.parents('.rescue-buttons').find('.btn-rescued').data('rescue-id', response.rescue_id);
              },
              error: function(xhr, status, error) {
                // Tangani respon gagal
                console.log(xhr.responseText);
              }
            });
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
            $.ajax({
              url: "{{ route('rescues.update', ['rescue' => 'RESCUE_ID']) }}".replace('RESCUE_ID', self.data('rescue-id')),
              method: "PUT",
              data: {
                rescue_id: self.data('rescue-id')
              },
              success: function(response) {
                // Tangani respon sukses
                console.log(response.rescue_id);
                self.parents('.rescue-buttons').remove();
                $(".btn-rescued").not(self).parents('.card.dog-list').parent().remove();
                $('.vet-title').text('Vet Place');
                $('#section-squad').remove();
              },
              error: function(xhr, status, error) {
                // Tangani respon gagal
                console.log(xhr.responseText);
              }
            });
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
          if (result.isConfirmed) {
            $.ajax({
              url: "{{ route('rescues.destroy', ['rescue' => 'RESCUE_ID']) }}".replace('RESCUE_ID', self.data('rescue-id')),
              method: "DELETE",
              data: {
                rescue_id: self.data('rescue-id')
              },
              success: function(response) {
                // Tangani respon sukses
                console.log(response.rescue_id);
                $(".btn-rescue").not(self).prop('disabled', true);
                self.parent().addClass('d-none');
                self.parents('.rescue-buttons').find('.rescuing-btns').toggleClass('d-none', 'd-block');
                self.parents('.rescue-buttons').find('.btn-rescued').data('rescue-id', response.rescue_id);
              },
              error: function(xhr, status, error) {
                // Tangani respon gagal
                console.log(xhr.responseText);
              }
            });
          }
        })
      });
    });
  </script>
@endsection