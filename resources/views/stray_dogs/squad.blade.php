@extends('layouts.app')

@section('content')

@if (($stray_dog->rescue()->exists()) && ($stray_dog->rescue->status != 'rescued'))
<section id="section-squad" class="mt-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 p-5 text-center">
          <p>Mission Paws’ible Pet Taxi can assist in moving the animal to the closest vet </p>
            <!-- <p>Let's order and tell them where you want to rescue the dog</p> -->
          <a href="https://balibuddies.com/pet-friendly-transport-in-bali-with-grab-pet/" type="button" class="btn btn-custom-submit w-100">
            {{ __('Grab Pets') }}
          </a>
          <div class="dropdown">
            <button class="btn btn-custom-submit w-100 mt-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ __('I need a dog Cacher') }}
            </button>
            <ul class="dropdown-menu w-100">
              <li><a class="dropdown-item" href="https://wa.me/+6289526902626">Whatsapp Surya </a></li>
              <li><a class="dropdown-item" href="https://wa.me/+6281337422297">Whatsapp Nana</a></li>
            </ul>
            <span class="fw-semibold">Ignore this if you want rescue by yourself </span><br>
            <small class="fs-6" style="color:#b41986;">*click <a href="{{ route('stray_dogs.show', $stray_dog->id) }}#vets place" style="text-decoration: underline; color:#BD1A8D">rescued button</a> if the dog is already in vet.</small>
          </div>
        </div>
      </div>
    </div>
  </section>
@endif

@endsection