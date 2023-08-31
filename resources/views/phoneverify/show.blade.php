@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            @if($errors->any())
            <div class="alert alert-danger" role="alert">
                {{$errors->first()}}
            </div>
            @endif
            <v-card class="card">
                <div class="card-header">Verify your phone</div>
                <div class="card-body">
                    <p>Thanks for registering! We've sent you a verification code, please provide the code below to activate your account.</p>

                    <div class="d-flex justify-content-center">
                        <div class="col-8">
                            <form method="post" action="{{ route('phoneverification.verify') }}">
                                @csrf
                                <div class="form-group">
                                    <input id="code" class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}" name="code" type="text" placeholder="Verification Code" required autofocus>
                                    @if ($errors->has('code'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group py-2">
                                    <v-btn type="submit" class="primary">Verify Phone</v-btn>
                                </div>

                                <div class="py-2 text-center">
                                    <a style="color: #ff8503" href="resend">Resend</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </v-card>
        </div>
    </div>
</div>
@endsection