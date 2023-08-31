@extends('layouts.app')

@section('content')
<div style="padding-top: 50px; background-image: url('https://static.wixstatic.com/media/11062b_63728f9042674bd9a69303659c7037cb~mv2.jpg/v1/fill/w_2024,h_1660,al_c,q_90,usm_0.66_1.00_0.01,enc_auto/11062b_63728f9042674bd9a69303659c7037cb~mv2.jpg); background-size: cover; width: 100%; height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <v-card class="card">
                <!-- <div class="text-right pa-2"> <a href="/register" style="color: #ff8503; text-decoration: none;">Register To Receive Coupons ›</a></div> -->

                <div class="d-flex flex-column justify-space-between align-center pa-8"><v-img :src="'/images/FullLogo_Transparent_NoBuffer.png'" alt="Login" max-width="200px" /></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register-new-customer') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Business Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">Business Contact Number (+1)</label>

                            <div class="col-md-6">

                                <input id="phone" type="text" class="input__input form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required autofocus>

                                @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Business Email</label>

                            <div class="col-md-6">

                                <input id="email" type="text" class="input__input form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="desc" class="col-md-4 col-form-label text-md-right">Business Description</label>

                            <div class="col-md-6">

                                <input id="desc" type="text" class="input__input form-control{{ $errors->has('desc') ? ' is-invalid' : '' }}" name="desc" value="{{ old('desc') }}" required autofocus>

                                @if ($errors->has('desc'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('desc') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row my-2">
                            <div class="d-flex flex-column justify-space-between align-center">
                                <v-btn type="submit" class="primary">
                                    {{ __('Register') }}
                                </v-btn>
                            </div>
                        </div>
                    </form>
                </div>
            </v-card>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            tab: null
        }
    });
</script>
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