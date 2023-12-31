@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>

<body id="app-layout">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <v-card class="card mt-4">
                <v-card-text class="text-center text-body text-h6">
                    Start your subscription to the {{ $plan->plan_name }} plan
                    <br>
                    Up to {{ $plan->max_smses }} coupons per month for ${{ $plan->monthly_price }}
                </v-card-text>
                <v-card-text>
                    <div class="col-md-12">
                        {!! Form::open(['url' => route('payment-create'), 'data-parsley-validate', 'id' => 'payment-form']) !!}
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                        @elseif ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                        @endif
                        <div class="form-group" id="cc-group">
                            {!! Form::label(null, 'Card Number:') !!}
                            {!! Form::text(null, null, [
                            'class' => 'form-control',
                            'required' => 'required',
                            'data-stripe' => 'number',
                            'data-parsley-type' => 'number',
                            'maxlength' => '16',
                            'data-parsley-trigger' => 'change focusout',
                            'data-parsley-class-handler' => '#cc-group'
                            ]) !!}
                        </div>
                        <div class="form-group" id="ccv-group">
                            {!! Form::label(null, 'CVC (3 or 4 digit number):') !!}
                            {!! Form::text(null, null, [
                            'class' => 'form-control',
                            'required' => 'required',
                            'data-stripe' => 'cvc',
                            'data-parsley-type' => 'number',
                            'data-parsley-trigger' => 'change focusout',
                            'maxlength' => '4',
                            'data-parsley-class-handler' => '#ccv-group'
                            ]) !!}
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" id="exp-m-group">
                                    {!! Form::label(null, 'Ex. Month') !!}
                                    {!! Form::selectMonth(null, null, [
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'data-stripe' => 'exp-month'
                                    ], '%m') !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="exp-y-group">
                                    {!! Form::label(null, 'Ex. Year') !!}
                                    {!! Form::selectYear(null, date('Y'), date('Y') + 10, null, [
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'data-stripe' => 'exp-year'
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        {!! Form::hidden('plan', $plan->id) !!}
                        <div class="text-center py-4">
                            {!! Form::submit('Purchase', ['class' => 'btn primary', 'id' => 'submitBtn', 'style' => 'margin-bottom: 10px;']) !!}
                            </d>
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="payment-errors" style="color: red;margin-top:10px;"></span>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                </v-card-text>
            </v-card>
        </div>
    </div>
    </div>
    </div>

    <script>
        window.ParsleyConfig = {
            errorsWrapper: '<div></div>',
            errorTemplate: '<div class="alert alert-danger parsley" role="alert"></div>',
            errorClass: 'has-error',
            successClass: 'has-success'
        };
    </script>

    <script src="https://parsleyjs.org/dist/parsley.js"></script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script>
        Stripe.setPublishableKey("<?php echo env('STRIPE_KEY') ?>");
        jQuery(function($) {
            $('#payment-form').submit(function(event) {
                var $form = $(this);
                $form.parsley().subscribe('parsley:form:validate', function(formInstance) {
                    formInstance.submitEvent.preventDefault();
                    alert();
                    return false;
                });
                $form.find('#submitBtn').prop('disabled', true);
                Stripe.card.createToken($form, stripeResponseHandler);
                return false;
            });
        });

        function stripeResponseHandler(status, response) {
            var $form = $('#payment-form');
            if (response.error) {
                $form.find('.payment-errors').text(response.error.message);
                $form.find('.payment-errors').addClass('alert alert-danger');
                $form.find('#submitBtn').prop('disabled', false);
            } else {
                var token = response.id;
                $form.append($('<input type="hidden" name="stripeToken" />').val(token));
                $form.get(0).submit();
            }
        };
    </script>
</body>

</html>
@endsection
