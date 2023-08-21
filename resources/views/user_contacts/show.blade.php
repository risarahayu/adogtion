@extends('layouts.app')

@section('content')
<div class="container  d-grid" style="place-items:center;">
  <div class="card col-8">
    <div class="card-header">
      {{$name}}
    </div>
    <div class="card-body ">
      <div class="d-flex"><i class="bi bi-whatsapp me-4"></i><a href="https://wa.me/{{$contact->whatsapp}} ">{{$contact->whatsapp ?? '-'}}</a></div>
      <div class="d-flex"><i class="bi bi-envelope me-4"></i></i><a href="mailto:{{$contact->whatsapp}}">{{$contact->email ?? '-'}}</a></div>
      <div class="d-flex"><i class="bi bi-instagram me-4"></i></i>{{$contact->instagram ?? '-'}}</div>
      <div class="d-flex"><i class="bi bi-facebook me-4"></i></i>{{$contact->facebook ?? '-'}}</div>
      <div class="d-flex"><i class="bi bi-telegram me-4"></i></i>{{$contact->telegram ?? '-'}}</div>
    </div>
  </div>
</div>
@endsection