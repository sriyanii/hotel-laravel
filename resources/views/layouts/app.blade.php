<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <title>Hotel Abadi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .custom-card {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    .custom-card img {
        height: 100%;
        object-fit: cover;
    }
</style>

</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="#">Hotel Abadi</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        @auth
            @if (auth()->user()->role === 'admin')
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            @elseif (auth()->user()->role === 'resepsionis')
                <li class="nav-item"><a class="nav-link" href="{{ route('resepsionis.dashboard') }}">Dashboard</a></li>
            @endif
        @endauth
      </ul>

      <ul class="navbar-nav ms-auto">
        @auth
          <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button class="btn btn-outline-danger btn-sm">Logout</button>
            </form>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>




  <!-- KONTEN HALAMAN -->
  <div class="container">
    @yield('content')
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
