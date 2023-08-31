@extends('layouts.app')

@section('content')
<div style="padding-top: 50px; background-image: url('https://static.wixstatic.com/media/11062b_63728f9042674bd9a69303659c7037cb~mv2.jpg/v1/fill/w_2024,h_1660,al_c,q_90,usm_0.66_1.00_0.01,enc_auto/11062b_63728f9042674bd9a69303659c7037cb~mv2.jpg); background-size: cover; width: 100%; height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <v-card class="card">
                <div class="d-flex flex-column justify-space-between align-center pa-8"><v-img :src="'/images/FullLogo_Transparent_NoBuffer.png'" alt="Login" max-width="200px" /></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">Business Email</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="input__input form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>

                                @if ($errors->has('username'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="d-flex flex-column justify-space-between align-center">
                                <v-btn type="submit" class="primary">
                                    {{ __('Login') }}
                                </v-btn>

                                @if (Route::has('password.request'))
                                <a class="btn btn-link" href="/password-reset">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </v-card>
        </div>
    </div>
</div>
@endsection

<style>
    .unit-input {
        display: inline-flex;
    }

    .unit-input__input {
        padding: .5em;
    }

    .unit-input__input:focus {
        background: #EDFFFB;
        outline: none;
    }

    .unit-input__prepend,
    .unit-input__append {
        background: #F4F4F4;
        padding: .5em;
        flex-grow: 0;
    }
</style>
