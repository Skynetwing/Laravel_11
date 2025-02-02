<!DOCTYPE html>
<html lang="en">
<head>
  <head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>404</title>
  <link id="main-css-href" rel="stylesheet" href="{{ asset('assets/css/style.css')}}" />
  <link href="{{ asset('assets/images/favicon.png')}}" rel="shortcut icon" />
</head>
</head>
  <body class="bg-light-gray" id="body">
  <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh">
  <div class="d-flex flex-column justify-content-between">
    <div class="row justify-content-center mt-5">
      <div class="text-center page-404">
        <h1 class="error-title">404</h1>
        <p class="pt-4 pb-5 error-subtitle">Looks like something went wrong.</p>
        <a href="{{ route('home') }}" class="btn btn-primary btn-pill">Back to Home</a>
      </div>
    </div>
  </div>
</div>
</body>
</html>
