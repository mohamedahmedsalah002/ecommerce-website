@include('layouts.head.head')

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{route('welcome')}}">
      <img src="{{ asset('images/Logo.png') }}" alt="Logo" width="70">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <div class="d-flex w-100">
        <!-- Search bar centered on larger screens -->
        <div class="d-none d-lg-flex flex-fill justify-content-center">
          <input class="form-control w-50" type="search" placeholder="Search" aria-label="Search">
        </div>

        <!-- Icons aligned to the right on larger screens -->
        <div class="d-flex align-items-center ms-auto">
          @auth
            <!-- Authenticated users -->
            @if (Auth::user()->role === 'admin')
              <!-- Admin -->
              <a class="d-flex align-items-center me-3 text-dark text-decoration-none" href="{{ route('logout') }}">
                <i class="fa fa-sign-out-alt me-1 fs-4"></i>
                <span class="ms-1">Logout</span>
              </a>
            @else
              <!-- Non-admin authenticated users -->
              <a href="{{ route('cart.view') }}" class="d-flex align-items-center me-3 text-dark text-decoration-none">
                <i class="bx bx-cart fs-3"></i>
              </a>
              <a class="d-flex align-items-center me-3 text-dark text-decoration-none" href="{{ route('logout') }}">
                <i class="fa fa-sign-out-alt me-1 fs-4"></i>
                <span class="ms-1">Logout</span>
              </a>
            @endif
          @else
            <!-- Guests -->
            <a href="{{ route('cart.view') }}" class="d-flex align-items-center me-3 text-dark text-decoration-none">
              <i class="bx bx-cart fs-3"></i>
            </a>
            <a href="{{ route('login') }}" class="d-flex align-items-center me-3 text-dark text-decoration-none">
              <i class="fa fa-sign-in-alt fs-3"></i>
              <span class="ms-1">Login</span>
            </a>
          @endauth
        </div>
      </div>
    </div>
  </div>
</nav>

<style>
/* Optional: Add shadow or further customization */
.navbar {
  padding: 1rem;
}

.text-dark {
  color: #000;
}

.text-decoration-none {
  text-decoration: none;
}
</style>
