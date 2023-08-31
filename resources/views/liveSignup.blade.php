@extends('layouts.live')

@section('content')
<div style="padding-top: 50px; background-size: cover; width: 100%; height: 100vh; background: {{$details['theme']}}">
    <div class="row justify-content-center">
        <live-signup :details='@json($details)'></live-signup>

        <!-- <div class="col-md-8">
            <v-card class="card">

                <div class="d-flex flex-column justify-space-between align-center pa-8"><v-img src="{{ $details->logo_location }}" alt="Login" max-width="200px" /></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('do-live-signup') }}">
                        @csrf

                        {{ Form::hidden('customer_id', $details['user_id']) }}
                        {{ Form::hidden('details', $details['user_id']) }}

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

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
                            <label for="phone" class="col-md-4 col-form-label text-md-right">Phone (+1)</label>

                            <div class="col-md-6">
                                <input id="phone" maxlength="10" type="text" class="input__input form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required autofocus>

                                @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="birthday" class="col-md-4 col-form-label text-md-right">Birthday</label>

                            <div class="col-md-6">
                                <v-menu ref="menu" v-model="menu" :close-on-content-click="false" transition="scale-transition" offset-y min-width="auto">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="birthday" label="Birthday date" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on"></v-text-field>
                                    </template>
                                    <v-date-picker v-model="birthday" :active-picker.sync="activePicker" :max="
                                                new Date(
                                                    Date.now() -
                                                        new Date().getTimezoneOffset() *
                                                            60000
                                                )
                                                    .toISOString()
                                                    .substring(0, 10)
                                            " min="1950-01-01" @click="$refs.menu.save(birthday)"></v-date-picker>
                                </v-menu>
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

                        <div class="row mb-3">
                            <label for="agree" class="col-md-4 col-form-label text-md-end"></label>

                            <div class="col-md-6">
                                By registering, you agree to our <span><a target="_blank" href="/user-agreement">Terms & Conditions</a></span> and that you are over 21 years of age.
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="d-flex flex-column justify-space-between align-center">
                                <v-btn type="submit" color="{{ $details->theme }}">
                                    {{ __('Register') }}
                                </v-btn>
                            </div>
                        </div>
                    </form>
                </div>
            </v-card>
        </div> -->
    </div>
</div>
@endsection
