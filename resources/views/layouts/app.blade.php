<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://js.stripe.com/v3/"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="shortcut icon" sizes="114x114" href="{{ asset('favicon.png') }}">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>

<body>
    <div id="app">
        <main>
            <v-app app>
                <div>
                    <v-app-bar>
                        <v-app-bar-nav-icon>
                            <v-img :src="'/images/IconOnly_Transparent.png'" max-height="50" max-width="50px" contain></v-img>
                        </v-app-bar-nav-icon>

                        <a href="/home"><v-img class="mx-2" :src="'/images/TextOnly.png'" max-height="40" max-width="150px" contain></v-img></a>

                        <v-spacer></v-spacer>

                        @guest
                        @if (Route::has('login'))
                        <div>
                            <v-list-item class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </v-list-item>
                        </div>
                        @endif

                        @if (Route::has('register'))
                        <div>
                            <v-list-item class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </v-list-item>
                        </div>
                        @endif
                        @else
                        <div>
                            <v-list-item class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                    @hasrole('Super-Admin')
                                    <a class="dropdown-item" href="/admin-tools">
                                        Admin
                                    </a>
                                    @endhasrole

                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </v-list-item>
                        </div>
                        @endguest
                    </v-app-bar>
                </div>
                <div>@yield('content')</div>

            </v-app>
        </main>
    </div>
</body>

</html>
