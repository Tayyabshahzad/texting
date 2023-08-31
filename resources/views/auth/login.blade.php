<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Style Sheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/signin.css') }}/" />
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <!-- Poppins Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- Slick Slider CDN -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <title>Sign In</title>
</head>

<body>
    <section class="td-signin">
        <a href="{{ route('index') }}"><img class="img-fluid td-logo position-absolute"
            src="{{ asset('assets/images/logo.png') }}"
                alt="Logo" /></a>
        <div class="container td-signin-container text-center">
            <div class="row">
                <div class="col-xxl-6 col-12 px-lg-0 px-5 signin-form">
                    <ul class="nav nav-pills mb-5 mx-auto justify-content-center" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-user-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-user" type="button" role="tab" aria-controls="pills-user"
                                aria-selected="true">
                                user login
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-business-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-business" type="button" role="tab"
                                aria-controls="pills-business" aria-selected="false">
                                business login
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-user" role="tabpanel"
                            aria-labelledby="pills-user-tab">
                            <form class="user-form text-center" method="post" action="{{ route('login')}}" >
                                @csrf
                                <h2 class="user-form-title">
                                    <span>Sign In</span> to Texting Discounts
                                </h2>
                                <div class="mb-3">
                                    <input type="text" placeholder="Username" class="form-control" id="inputEmail"
                                        name="username"  required/>
                                    @error('username')
                                        <small class="text-danger">
                                            <{{ $message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <div class="position-relative">
                                        <input type="password" placeholder="Password" class="form-control"
                                            id="inputPassword" name="password" required />
                                        <span class="td-eye-icon position-absolute"><img class="td-eye-icon"
                                                src="./assets/images/eye.svg" alt="show/hide icon" /></span>
                                    </div>
                                </div>
                                <div class="mb-3 form-check d-flex justify-content-between">
                                    <div class="checkBox">
                                        <input type="checkbox" class="form-check-input" id="rememberMe" />
                                        <label class="form-check-label" for="rememberMe">Remember me?</label>
                                    </div>
                                    <a href="#">Forget Password ?</a>
                                </div>
                                <button type="submit" class="td-signForm-btn">Login</button>
                                <p>Do you have an account? <a href="{{ route('register') }}">Sign Up</a></p>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="pills-business" role="tabpanel"
                            aria-labelledby="pills-business-tab">
                            <form class="user-form text-center" method="post" action="{{ route('login')}}" >
                                <h2 class="user-form-title">
                                    <span>Sign In</span> to Texting Discounts
                                </h2>
                                @csrf
                                <div class="mb-3">
                                    <input type="text" placeholder="Username" class="form-control" id="inputEmail"
                                    name="username"  required/>
                                    @error('username')
                                        <small class="text-danger">
                                            <{{ $message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <div class="position-relative">
                                        <input type="password" placeholder="Password" class="form-control"
                                            id="inputPassword" name="password" required />
                                        <span class="td-eye-icon position-absolute">
                                            <img class="td-eye-icon"  src="./assets/images/eye.svg" alt="show/hide icon" /></span>
                                    </div>
                                </div>
                                <div class="mb-3 form-check d-flex justify-content-between">
                                    <div class="checkBox">
                                        <input type="checkbox" class="form-check-input" id="rememberMe" />
                                        <label class="form-check-label" for="rememberMe">Remember me?</label>
                                    </div>
                                    <a href="#">Forget Password ?</a>
                                </div>
                                <button type="submit" class="td-signForm-btn">SIGN</button>
                                <p>Do you have an account? <a href="{{ route('register') }}">Sign Up</a></p>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-12 py-lg-2 py-5 px-lg-0 px-5">
                    <img class="img-fluid" src="./assets/images/signin-hero.png" alt="Sign In Banner" />
                </div>
            </div>
        </div>
    </section>
</body>
</html>
