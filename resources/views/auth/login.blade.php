<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Hotel Abadi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>

  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="width: 350px;">
      <h3 class="text-center mb-3">Login</h3>

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('login.process') }}">
        @csrf

        <div class="mb-3">
          <label for="role" class="form-label">Login Sebagai</label>
          <select class="form-select" name="role" id="role" required>
            <option value="" disabled selected>-- Pilih Role --</option>
            <option value="admin">Admin</option>
            <option value="resepsionis">Resepsionis</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" class="form-control" id="email" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Kata Sandi</label>
          <input type="password" name="password" class="form-control" id="password" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
