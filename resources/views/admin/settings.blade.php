@extends('layouts.master')
@section('content')
    <div class="row td-settings">
        <div class="col-md-12 px-5 py-3">
            <h2 class="td-dashboard-title">Settings</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 px-5 py-3 td-setting-tabs">
            <div class="d-flex align-items-start">
                <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home"
                        aria-selected="true">
                        <svg width="41" height="40">
                            <path
                                d="M33.7117 5C34.5958 5 35.4436 5.35119 36.0688 5.97631C36.6939 6.60143 37.0451 7.44928 37.0451 8.33333V31.6667C37.0451 32.5507 36.6939 33.3986 36.0688 34.0237C35.4436 34.6488 34.5958 35 33.7117 35H7.04506C6.16101 35 5.31316 34.6488 4.68804 34.0237C4.06292 33.3986 3.71173 32.5507 3.71173 31.6667V8.33333C3.71173 7.44928 4.06292 6.60143 4.68804 5.97631C5.31316 5.35119 6.16101 5 7.04506 5H33.7117ZM33.7117 8.33333H7.04506V31.6667H33.7117V8.33333ZM28.7117 25C29.1365 25.0005 29.5451 25.1631 29.854 25.4547C30.1629 25.7464 30.3488 26.1449 30.3737 26.569C30.3986 26.9931 30.2606 27.4106 29.988 27.7364C29.7153 28.0621 29.3286 28.2715 28.9067 28.3217L28.7117 28.3333H12.0451C11.6203 28.3329 11.2117 28.1702 10.9028 27.8786C10.5939 27.587 10.408 27.1884 10.3831 26.7643C10.3582 26.3403 10.4962 25.9227 10.7688 25.5969C11.0415 25.2712 11.4282 25.0618 11.8501 25.0117L12.0451 25H28.7117ZM17.0451 11.6667C17.9291 11.6667 18.777 12.0179 19.4021 12.643C20.0272 13.2681 20.3784 14.1159 20.3784 15V18.3333C20.3784 19.2174 20.0272 20.0652 19.4021 20.6904C18.777 21.3155 17.9291 21.6667 17.0451 21.6667H13.7117C12.8277 21.6667 11.9798 21.3155 11.3547 20.6904C10.7296 20.0652 10.3784 19.2174 10.3784 18.3333V15C10.3784 14.1159 10.7296 13.2681 11.3547 12.643C11.9798 12.0179 12.8277 11.6667 13.7117 11.6667H17.0451ZM28.7117 18.3333C29.1538 18.3333 29.5777 18.5089 29.8902 18.8215C30.2028 19.134 30.3784 19.558 30.3784 20C30.3784 20.442 30.2028 20.8659 29.8902 21.1785C29.5777 21.4911 29.1538 21.6667 28.7117 21.6667H23.7117C23.2697 21.6667 22.8458 21.4911 22.5332 21.1785C22.2207 20.8659 22.0451 20.442 22.0451 20C22.0451 19.558 22.2207 19.134 22.5332 18.8215C22.8458 18.5089 23.2697 18.3333 23.7117 18.3333H28.7117ZM17.0451 15H13.7117V18.3333H17.0451V15ZM28.7117 11.6667C29.1365 11.6671 29.5451 11.8298 29.854 12.1214C30.1629 12.413 30.3488 12.8116 30.3737 13.2357C30.3986 13.6597 30.2606 14.0773 29.988 14.4031C29.7153 14.7288 29.3286 14.9382 28.9067 14.9883L28.7117 15H23.7117C23.2869 14.9995 22.8783 14.8369 22.5695 14.5453C22.2606 14.2536 22.0747 13.8551 22.0498 13.431C22.0249 13.0069 22.1629 12.5894 22.4355 12.2636C22.7082 11.9379 23.0949 11.7285 23.5167 11.6783L23.7117 11.6667H28.7117Z"
                                fill="#33343F" />
                        </svg>
                        Personal Information
                    </button>
                    <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile"
                        aria-selected="false">
                        <svg width="40" height="40">
                            <path
                                d="M10 28.3333C10 25 16.6667 23.1667 20 23.1667C23.3333 23.1667 30 25 30 28.3333V30H10M25 15C25 16.3261 24.4732 17.5979 23.5355 18.5355C22.5979 19.4732 21.3261 20 20 20C18.6739 20 17.4021 19.4732 16.4645 18.5355C15.5268 17.5979 15 16.3261 15 15C15 13.6739 15.5268 12.4021 16.4645 11.4645C17.4021 10.5268 18.6739 10 20 10C21.3261 10 22.5979 10.5268 23.5355 11.4645C24.4732 12.4021 25 13.6739 25 15ZM5 8.33333V31.6667C5 32.5507 5.35119 33.3986 5.97631 34.0237C6.60143 34.6488 7.44928 35 8.33333 35H31.6667C32.5507 35 33.3986 34.6488 34.0237 34.0237C34.6488 33.3986 35 32.5507 35 31.6667V8.33333C35 7.44928 34.6488 6.60143 34.0237 5.97631C33.3986 5.35119 32.5507 5 31.6667 5H8.33333C7.44928 5 6.60143 5.35119 5.97631 5.97631C5.35119 6.60143 5 7.44928 5 8.33333Z"
                                fill="#33343F" />
                        </svg>
                        Profile Photo
                    </button>
                    <button class="nav-link " id="v-pills-messages-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages"
                        aria-selected="false">
                        <svg width="42" height="40">
                            <path
                                d="M20.7095 28.3333C21.6114 28.3333 22.4765 27.9821 23.1143 27.357C23.7521 26.7319 24.1104 25.8841 24.1104 25C24.1104 24.1159 23.7521 23.2681 23.1143 22.643C22.4765 22.0179 21.6114 21.6667 20.7095 21.6667C19.8075 21.6667 18.9425 22.0179 18.3047 22.643C17.6669 23.2681 17.3086 24.1159 17.3086 25C17.3086 25.8841 17.6669 26.7319 18.3047 27.357C18.9425 27.9821 19.8075 28.3333 20.7095 28.3333ZM30.9122 13.3333C31.8141 13.3333 32.6792 13.6845 33.317 14.3096C33.9548 14.9348 34.3131 15.7826 34.3131 16.6667V33.3333C34.3131 34.2174 33.9548 35.0652 33.317 35.6904C32.6792 36.3155 31.8141 36.6667 30.9122 36.6667H10.5068C9.60479 36.6667 8.73976 36.3155 8.10197 35.6904C7.46417 35.0652 7.10587 34.2174 7.10587 33.3333V16.6667C7.10587 15.7826 7.46417 14.9348 8.10197 14.3096C8.73976 13.6845 9.60479 13.3333 10.5068 13.3333H12.2072V10C12.2072 7.78987 13.103 5.67025 14.6975 4.10745C16.292 2.54465 18.4545 1.66667 20.7095 1.66667C21.826 1.66667 22.9316 1.88222 23.9631 2.30101C24.9947 2.7198 25.932 3.33363 26.7215 4.10745C27.511 4.88127 28.1372 5.79993 28.5645 6.81098C28.9918 7.82202 29.2117 8.90566 29.2117 10V13.3333H30.9122ZM20.7095 5.00001C19.3565 5.00001 18.059 5.52679 17.1023 6.46447C16.1456 7.40215 15.6081 8.67392 15.6081 10V13.3333H25.8108V10C25.8108 8.67392 25.2734 7.40215 24.3167 6.46447C23.36 5.52679 22.0624 5.00001 20.7095 5.00001Z"
                                fill="#33343F" />
                        </svg>
                        Change Your Password
                    </button>

                    <button class="nav-link " id="v-pills-survey-tab" data-bs-toggle="pill" data-bs-target="#v-survey"
                        type="button" role="tab" aria-controls="v-pills-survey" aria-selected="false">
                        <svg width="42" height="40">
                            <path
                                d="M20.7095 28.3333C21.6114 28.3333 22.4765 27.9821 23.1143 27.357C23.7521 26.7319 24.1104 25.8841 24.1104 25C24.1104 24.1159 23.7521 23.2681 23.1143 22.643C22.4765 22.0179 21.6114 21.6667 20.7095 21.6667C19.8075 21.6667 18.9425 22.0179 18.3047 22.643C17.6669 23.2681 17.3086 24.1159 17.3086 25C17.3086 25.8841 17.6669 26.7319 18.3047 27.357C18.9425 27.9821 19.8075 28.3333 20.7095 28.3333ZM30.9122 13.3333C31.8141 13.3333 32.6792 13.6845 33.317 14.3096C33.9548 14.9348 34.3131 15.7826 34.3131 16.6667V33.3333C34.3131 34.2174 33.9548 35.0652 33.317 35.6904C32.6792 36.3155 31.8141 36.6667 30.9122 36.6667H10.5068C9.60479 36.6667 8.73976 36.3155 8.10197 35.6904C7.46417 35.0652 7.10587 34.2174 7.10587 33.3333V16.6667C7.10587 15.7826 7.46417 14.9348 8.10197 14.3096C8.73976 13.6845 9.60479 13.3333 10.5068 13.3333H12.2072V10C12.2072 7.78987 13.103 5.67025 14.6975 4.10745C16.292 2.54465 18.4545 1.66667 20.7095 1.66667C21.826 1.66667 22.9316 1.88222 23.9631 2.30101C24.9947 2.7198 25.932 3.33363 26.7215 4.10745C27.511 4.88127 28.1372 5.79993 28.5645 6.81098C28.9918 7.82202 29.2117 8.90566 29.2117 10V13.3333H30.9122ZM20.7095 5.00001C19.3565 5.00001 18.059 5.52679 17.1023 6.46447C16.1456 7.40215 15.6081 8.67392 15.6081 10V13.3333H25.8108V10C25.8108 8.67392 25.2734 7.40215 24.3167 6.46447C23.36 5.52679 22.0624 5.00001 20.7095 5.00001Z"
                                fill="#33343F" />
                        </svg>
                        Survey
                    </button>

                </div>
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                        aria-labelledby="v-pills-home-tab">
                        <form class="setting-form" method="post" action="{{ route('update-settings') }}">
                            @csrf
                            <input type="hidden" name="type" value="info">
                            <label>First Name</label>
                            <input class="form-control form-control-lg" type="text" required name="name"
                                placeholder="First Name" value="{{ Auth::user()->name }}" />
                            @error('name')
                                <small class="text-danger">{{ $message }}</small> <br><br>
                            @enderror
                            <label>Birthday</label>
                            <input class="form-control form-control-lg" type="date" required name="birthday"
                                value="{{ Auth::user()->birthday }}" />
                            @error('birthday')
                                <small class="text-danger">{{ $message }}</small> <br><br>
                            @enderror
                            <label>Email</label>
                            <input class="form-control form-control-lg" type="text" disabled
                                value="{{ Auth::user()->email }}" />
                            <label>Phone Number</label>
                            <input class="form-control form-control-lg" type="text" required name="phone"
                                placeholder="000-000-000" value="{{ Auth::user()->phone }}" />
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small> <br><br>
                            @enderror
                            <label>Description</label>
                            <input class="form-control form-control-lg" type="text" name="description"
                                placeholder="000-000-000" value="{{ Auth::user()->customerDetails->description }}" />
                            @error('description')
                                <small class="text-danger">{{ $message }}</small> <br><br>
                            @enderror
                            <label>Coupon Verification Code </label>
                            <input class="form-control form-control-lg" type="text" name="verification_code"
                                placeholder="000-000-000"
                                value="{{ Auth::user()->customerDetails->verification_code }}" />
                            @error('verification_code')
                                <small class="text-danger">{{ $message }}</small> <br><br>
                            @enderror
                            <label> Google Maps URL </label>
                            <input class="form-control form-control-lg" type="text" name="map_url"
                                value="{{ Auth::user()->customerDetails->map_url }}" />
                            @error('map_url')
                                <small class="text-danger">{{ $message }}</small> <br><br>
                            @enderror
                            <button type="submit" class="submitBtn">Save</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                        aria-labelledby="v-pills-profile-tab">
                        <form class="upload-form" enctype="multipart/form-data" method="post"
                            action="{{ route('update-settings') }}">
                            <input type="hidden" name="type" value="logo">
                            @csrf
                            <label class="drop-container" id="dropcontainer" for="fileInput">
                                <span class="drop-title">Upload a Logo or drag and drop here</span>
                                JPG. PNG,JPEG Up to 100 MBs
                            </label>
                            <input type="file" id="fileInput" name="logo" accept="image/*" />
                            @error('logo')
                                <small class="text-danger">{{ $message }}</small> <br><br>
                            @enderror
                            <button type="submit" class="submitBtn">Save</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                        aria-labelledby="v-pills-messages-tab">
                        <form class="setting-form" method="post" action="{{ route('update-settings') }}">
                            @csrf
                            <input type="hidden" name="type" value="password">
                            <label>Current Password</label>
                            <input class="form-control form-control-lg" name="current_password" type="text"
                                placeholder="Current  Password" required />
                            @if ($errors->has('current_password'))
                                <small class="text-danger"> {{ $errors->first('current_password') }} </small> <br><br>
                            @endif
                            <label>New Password</label>
                            <input class="form-control form-control-lg" name="password" type="password"
                                placeholder="New Password" required min="8" />
                            @error('password')
                                <small class="text-danger">{{ $message }}</small> <br><br>
                            @enderror
                            <label>Confirm New Password</label>
                            <input class="form-control form-control-lg" name="password_confirmation" type="password"
                                placeholder="Confirm New Password" min="8" required />
                            @error('password_confirmation')
                                <small class="text-danger">{{ $message }}</small> <br><br>
                            @enderror
                            <button type="submit" class="submitBtn">Save</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="v-survey" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                        @if($survey)
                                <a href="{{ route('view-customer-survey') }}" target="_blank"> View Survey </a>
                        @else
                        <h3>
                            Create Survey
                        </h3>
                        <p>
                            Create a 3 question survey for your new subscribers to complete during sign-up
                        </p>
                        <form class="setting-form" method="post" action="{{ route('save-survey') }}">
                            @csrf
                            <div class="row">
                                @csrf
                                @for ($i = 0; $i < 3; $i++)
                                    <div class="col-lg-12 " style="margin-bottom:10px;">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label> Question {{ $i + 1 }}</label>
                                                <input class="form-control form-control-lg" name="questions[]"
                                                    type="text" placeholder="Question {{ $i + 1 }}" required />
                                            </div>

                                            @for ($j = 1; $j <= 4; $j++)
                                                <div class="col-lg-6">
                                                    <input class="form-control form-control-lg"
                                                        name="options[{{ $i }}][]" type="text"
                                                        placeholder="Option {{ $j }}" required />
                                                </div>
                                            @endfor

                                            <div class="col-lg-12">
                                                @for ($j = 1; $j <= 4; $j++)
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="inlineCheckbox{{ $i + 1 }}_{{ $j }}"
                                                            value="{{ $j }}"
                                                            name="best_options[{{ $i }}][]" />
                                                        <label class="form-check-label"
                                                            for="inlineCheckbox{{ $i + 1 }}_{{ $j }}">
                                                            &nbsp; Option {{ $j }}</label>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                            <button type="submit" class="submitBtn">Save</button>
                        </form>
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('page_js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var activeTab = '{{ session('active_tab') }}';
            if (activeTab === 'password') {
                var passwordTabLink = document.getElementById('v-pills-messages-tab');
                var passwordTabContent = document.getElementById('v-pills-messages');
                passwordTabLink.classList.add('active');
                passwordTabContent.classList.add('active', 'show');
                // Remove the 'active' class from other tab links
                var otherTabLinks = document.querySelectorAll('.nav-link:not(#v-pills-messages-tab)');
                otherTabLinks.forEach(function(link) {
                    link.classList.remove('active');
                });

                // Remove the 'active' class from other tab content areas
                var otherTabContents = document.querySelectorAll('.tab-pane.fade:not(#v-pills-messages)');
                otherTabContents.forEach(function(content) {
                    content.classList.remove('active', 'show');
                });
            } else if (activeTab === 'logo') {
                var passwordTabLink = document.getElementById('v-pills-profile-tab');
                var passwordTabContent = document.getElementById('v-pills-profile');
                passwordTabLink.classList.add('active');
                passwordTabContent.classList.add('active', 'show');
                // Remove the 'active' class from other tab links
                var otherTabLinks = document.querySelectorAll('.nav-link:not(#v-pills-profile-tab)');
                otherTabLinks.forEach(function(link) {
                    link.classList.remove('active');
                });

                // Remove the 'active' class from other tab content areas
                var otherTabContents = document.querySelectorAll('.tab-pane.fade:not(#v-pills-profile)');
                otherTabContents.forEach(function(content) {
                    content.classList.remove('active', 'show');
                });
            }
        });
    </script>
@endsection
