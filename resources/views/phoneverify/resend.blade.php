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
                    <p>Didnt receive your verification code?</p>

                    <div class="d-flex justify-content-center">
                        <div>
                            <form method="post" action="{{ route('phoneverification.resend.sms') }}">
                                @csrf
                                <div class="form-group py-2">
                                    <v-btn type="submit" class="primary">Resend</v-btn>
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