{{-- @extends('layouts.app')

@section('content')
<div style="padding-top: 50px; background-image: url('https://static.wixstatic.com/media/11062b_63728f9042674bd9a69303659c7037cb~mv2.jpg/v1/fill/w_2024,h_1660,al_c,q_90,usm_0.66_1.00_0.01,enc_auto/11062b_63728f9042674bd9a69303659c7037cb~mv2.jpg); background-size: cover; width: 100%; height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <register-component></register-component>
        </div>
    </div>
</div>
@endsection --}}

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
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

    <title>Registration</title>
</head>

<body>
    <section class="td-signin">
        <a href="{{ route('index') }}"><img class="img-fluid td-logo position-absolute"  src="{{ asset('assets/images/logo.png') }}" alt="Logo" /></a>
        <div class="container td-signin-container text-center">
            <div class="row">
                <div class="col-xxl-6 col-12 px-lg-0 px-5 signin-form" style="margin-top:10%">
                    <ul class="nav nav-pills mb-5 mx-auto justify-content-center" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-user-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-user" type="button" role="tab" aria-controls="pills-user"
                                aria-selected="true">
                                User
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-business-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-business" type="button" role="tab"
                                aria-controls="pills-business" aria-selected="false">
                                Business
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-user" role="tabpanel"
                            aria-labelledby="pills-user-tab">
                            <form class="user-form text-center" method="post" action="{{ route('register')}}" >
                                @csrf
                                <div class="mb-3">
                                    <input type="text" placeholder="Username" class="form-control" id="inputEmail"
                                        name="name"  required value="{{ old('name') }}"/>
                                        @error('name')
                                            <small class="text-danger">
                                                <{{ $message }}
                                            </small>
                                        @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="text" placeholder="Phone" pattern="[0-9]{10}" class="form-control" id="inputEmail"
                                        name="phone"  min="10"max="10" required value="{{ old('phone') }}"/>
                                    @error('phone')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="date" placeholder="Date of Birth" class="form-control" id="inputEmail"
                                        name="dob"  required value="{{ old('dob') }}"/>
                                        @error('dob')
                                            <small class="text-danger">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="password" placeholder="Password" class="form-control"
                                    id="inputPassword" name="password" required />
                                    @error('password')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <input type="password" placeholder="Confirm Password" class="form-control" id="inputEmail"
                                        name="password_confirmation"  required/>
                                        @error('confirmed')
                                            <small class="text-danger">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                </div>
                                <button type="submit" class="td-signForm-btn">SIGN UP</button>

                            </form>
                        </div>
                        <div class="tab-pane fade" id="pills-business" role="tabpanel"
                            aria-labelledby="pills-business-tab">
                            <form class="user-form text-center" method="post" action="{{ route('register-new-customer')}}" >
                                @csrf
                                <div class="mb-3">
                                    <input type="text" placeholder="User Name" class="form-control" id="inputEmail"
                                        name="name"  value="{{ old('name') }}" required/>
                                    @error('name')
                                        <small class="text-danger">
                                            <{{ $message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="text" placeholder="Phone" pattern="[0-9]{10}" class="form-control" id="inputEmail"
                                    name="phone"  min="10"max="10" required value="{{ old('phone') }}"/>
                                    @error('phone')
                                        <small class="text-danger">
                                            <{{ $message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="email" placeholder="Email Address" class="form-control" id="inputEmail"
                                        name="email"  required value="{{ old('email') }}"/>
                                    @error('email')
                                        <small class="text-danger">
                                            <{{ $message }}
                                        </small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <input type="text" placeholder="Description" class="form-control" id="inputEmail"
                                        name="description"   value="{{ old('description') }}" required/>
                                    @error('description')
                                        <small class="text-danger">
                                            <{{ $message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="password" placeholder="Password" class="form-control"
                                    id="inputPassword" name="password" required />
                                </div>

                                <div class="mb-3">
                                    <input type="password" placeholder="Confirm Password" class="form-control" id="inputEmail"
                                        name="password_confirmation"  required/>
                                </div>
                                <button type="submit" class="td-signForm-btn">SIGN UP</button>

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
<script src="{{ asset('assets/js/script.js') }}"></script>
</html>
