<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title')</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  
  <!-- GOOGLE MAP API -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqF9D-owlOuUfEv0hR3s7b_A_7eBFiXYQ&libraries=places&callback=initMap" async defer></script>
</head>
<body>
  @include('layouts.nav')

  <main class="py-4">
    @yield('content')
  </main>

  <footer>
    @include('layouts.footer')
  </footer>

  @yield('scripts')

  @if(session()->has('flash'))
    <script>
        toastify("{{ session('flash.type') }}", "{{ session('flash.message') }}");
    </script>
  @endif
</body>
</html>
