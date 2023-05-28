<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>@yield('title')</title>
    <!-- Include any CSS or JS files -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <header>
      <!-- Include your header content here -->
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
      <!-- Include your footer content here -->
    </footer>

    <!-- Include any additional scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
      @yield('scripts')
    </script>
</body>
</html>
