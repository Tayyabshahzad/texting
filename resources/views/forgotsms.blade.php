<!-- @extends('layouts.live')

@section('content')
<v-app-bar>
    <a href="/home"><v-img :src="'/images/IconOnly_Transparent.png'" max-height="50" max-width="50px" contain></v-img></a>

    <v-spacer></v-spacer>
</v-app-bar>
<div style="padding-top: 50px; background-image: url('https://static.wixstatic.com/media/11062b_63728f9042674bd9a69303659c7037cb~mv2.jpg/v1/fill/w_2024,h_1660,al_c,q_90,usm_0.66_1.00_0.01,enc_auto/11062b_63728f9042674bd9a69303659c7037cb~mv2.jpg'); background-size: cover; width: 100%; height: 100vh;">
    <div class=" row justify-content-center">
        <div class="col-md-6">
            <v-card class="card">

                <div class="d-flex flex-column justify-space-between align-center pa-8"></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('reset-password-sms') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">Phone (+1)</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="input__input form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required autofocus>

                                @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>


                        <div class="row mb-2">
                            <div class="d-flex flex-column justify-space-between align-center">
                                <v-btn type="submit" color="primary">
                                    {{ __('Reset Password') }}
                                </v-btn>
                            </div>
                        </div>
                    </form>
                </div>
            </v-card>
        </div>
    </div>
</div>
@endsection -->