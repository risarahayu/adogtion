<nav class="navbar navbar-expand-md navbar-dark shadow-sm adogtion-navbar">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">
      <img  src="{{ asset('images/mp_logo_big.svg') }}" alt="mp" width="50">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Left Side Of Navbar -->
      <ul class="navbar-nav me-auto">
      </ul>

      <!-- Right Side Of Navbar -->
      <ul class="navbar-nav ms-auto">
        <!-- Authentication Links -->
        @guest
          @if (Route::has('login'))
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
          @endif

          @if (Route::has('register'))
            <li class="nav-item">
              <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
          @endif
        @else
          <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">{{ __('Dashboard') }}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('stray_dogs.index') }}">{{ __('Dog List') }}</a>
          </li>
          @if (auth()->user()->administrator)
            <li class="nav-item">
              <a class="nav-link" href="{{ route('vets.index') }}">
                {{ __('Vet List') }}
              </a>
            </li>
          @endif
          <li class="nav-item">
            <a class="nav-link" href="{{ route('stray_dogs.create') }}">
              {{ __('Add New') }}
              <img src="{{ asset('images/paw.svg') }}" alt="SVG Image">
            </a>
          </li>
          <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              {{ Auth::user()->name }}
              <i class="bi bi-person-circle"></i>
            </a>

            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </div>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>