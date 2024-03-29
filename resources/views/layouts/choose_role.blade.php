<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Choose Role</title>

  <!-- css -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  
  <!-- js -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</head>
<body class="role-layout">
  <div class="container text-center">
    <h1 class="display-6 text-white p-5">Hi, What are you looking for?</h1>
    <div class="row">
      <div class="col">
        <a href="{{ route('role.set', ['role' => 'rescuer']) }}" class="btn btn-custom-role p-5">Rescue Dog</a>
      </div>
      <div class="col">
        <a href="{{ route('role.set', ['role' => 'adopter']) }}" class="btn btn-custom-role p-5">Adoption Dog</a>
      </div>
    </div>
  </div>
</body>
</html>
