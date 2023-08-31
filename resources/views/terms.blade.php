@extends('layouts.live')

@section('content')
<v-app-bar>
    <a href="/home"><v-img class="mx-2" src="{{ $details->logo_location }}" max-height="40" max-width="180px"></v-img></a>

    <v-spacer></v-spacer>
</v-app-bar>
<div style="padding-top: 50px; background-size: cover; width: 100%; height: 100vh; background: {{$details['theme']}}">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <v-card class="pa-4">
                <v-card-title>Terms & Conditions</v-card-title>
                <v-card-text>
                    By providing my phone number and opting in to receive SMS messages from {{ $details->name }}, I agree to the following terms and conditions: <br><br>


                    I understand that I am subscribing to receive SMS messages from {{ $details->name }} and that message and data rates may apply. <br>
                    I agree to receive promotional messages and updates from {{ $details->name }} via SMS.<br>
                    I understand that I can unsubscribe from SMS messages at any time by logging into the Texting Discounts portal and removing myself from the subscription.<br>
                    I acknowledge that Texting Discounts is the platform used by {{ $details->name }} to manage their SMS marketing and that I have read and agree to their privacy policy and terms of service.<br>
                    I certify that I am 21 years of age or older and have the legal capacity to enter into this agreement.<br>
                    To unsubscribe from SMS messages from {{ $details->name }}, please log into the Texting Discounts portal and remove yourself from the subscription.<br>

                    <br>
                    By providing my phone number and opting in to receive SMS messages from {{ $details->name }}, I agree to the terms and conditions outlined above.<br><br>


                    Thank you for choosing {{ $details->name }} and Texting Discounts as your preferred method of communication.
                </v-card-text>
                </v-card-title>
        </div>
    </div>
</div>
@endsection
