<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Style Sheet -->

    <!-- Bootstrap -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
    <!-- Poppins Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
      rel="stylesheet"
    />
    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- Slick Slider CDN -->
    <link
      rel="stylesheet"
      type="text/css"
      href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"
    />
    <script
      type="text/javascript"
      src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"
    ></script>
    @section('page_style')
    @show
    <title> Texting Discounts | @yield('title') </title>
  </head>
  <body>
    <!-- header -->
    <nav class="navbar navbar-expand-xl navbar-light">
      <div class="container td-container">
        <a class="navbar-brand" href="{{ route('index') }}" ><img class="img-fluid" src="{{ asset('assets/images/logo.png') }}" alt="Logo" /></a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#main-nav"
          aria-controls="main-nav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="main-nav">
          <ul class="navbar-nav mb-2 mb-lg-0 align-items-center">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="{{ route('index') }}"
                >Home</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Coming Soon</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('howItWorks') }}">How It Works</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('pricing.plans') }}">Pricing</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('bookOnline') }}">Book Online</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('contact') }}">Contact</a>
            </li>
            <li class="nav-item d-xl-none">
              <a class="nav-link" href="{{ route('login') }}">Sign In</a>
            </li>
            <li class="nav-item d-xl-none">
              <a class="nav-link" href="{{ route('register') }}">Sign Up </a>
            </li>
            <li class="nav-item ms-2 d-none d-md-inline">
              <a class="td-btn-signin" href="{{ route('login') }}">Sign In </a>
            </li>
            <li class="nav-item ms-2 d-none d-md-inline">
              <a class="td-btn-signup" href="{{ route('register') }}">Sign Up </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    @section('content')
    @show
    @section('content')
    @show
    <footer>
      <div class="container-fluid">
        <div class="container">
          <div class="row">
            <div class="col-md-12 text-center">
              <a class="navbar-brand" href="{{ route('index') }}"
                ><img
                  class="img-fluid"
                  src="{{ asset('assets/images/logo.png') }}"
                  alt="Logo"
              /></a>
            </div>
          </div>
          <div class="row justify-content-center mb-5">
            <div class="col-md-12">
              <ul
                class="d-md-flex d-block text-center gap-3 justify-content-center list-unstyled footer-nav"
              >
                <li><a href="{{ route('index') }}">Home</a></li>
                <li><a href="#">Coming Soon</a></li>
                <li><a href="{{ route('howItWorks') }}">How It Works</a></li>
                <li><a href="{{ route('pricing.plans') }}">Pricing</a></li>
                <li><a href="{{ route('bookOnline') }}">Book Online</a></li>
                <li><a href="{{ route('contact') }}">Contact</a></li>
              </ul>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <p class="text-white text-center footer-bottom">
                admin@textingdiscounts.com
              </p>
            </div>
          </div>
        </div>
      </div>
    </footer>

    @section('page_js')
    @show
    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>
</html>
