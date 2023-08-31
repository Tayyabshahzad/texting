@extends('layouts.app')

@section('content')
<div style="padding-top: 50px; background-image: url('https://static.wixstatic.com/media/11062b_63728f9042674bd9a69303659c7037cb~mv2.jpg/v1/fill/w_2024,h_1660,al_c,q_90,usm_0.66_1.00_0.01,enc_auto/11062b_63728f9042674bd9a69303659c7037cb~mv2.jpg'); background-size: cover; width: 100%; height: 150vh;">
    <!-- <div class="row justify-content-center">
        <div class="col-md-8">
            <v-card class="card">

            </v-card>
        </div>
    </div> -->

    <!-- {{ $plans}} -->
    <v-container>

        <v-row class="pa-4">
            @foreach($plans as $plan)

            <v-col class="col-sm-12 col-md-4">
                <v-card class="py-2" style="max-height: 420px; ">
                    @if($plan->id == 3)
                    <div class="text-center">
                        <v-chip color="primary" outlined label class="ma-2">
                            Most Popular
                        </v-chip>
                        <v-chip color="primary" label class="ma-2">
                            Best Value
                        </v-chip>
                    </div>
                    @else
                    <div class="text-center" style="visibility: hidden">
                        <v-chip color="primary" label class="ma-2">
                            Plan
                        </v-chip>
                    </div>
                    @endif

                    <v-list-item class="text-center">
                        <v-list-item-content>
                            <v-list-item-title class="text-h5">
                                {{ $plan->plan_name }}
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-card-text>
                        <v-row justify="center">
                            <v-col class="mx-0 text-center px-0 p-3" cols="12">
                                <span class="text-h5 align-items-top">$</span><span class="text-h2">{{ $plan->price }}</span>
                                @if($plan->type == 'Monthly')
                                <div class="text-center">
                                    <p>Every Month</p>
                                </div>
                                @else
                                <div class="text-center">
                                    <p>Every Year</p>
                                </div>
                                @endif
                            </v-col>

                            <v-card-text class="text-center">
                                Up to {{ $plan->max_smses }} Messages Per Month
                                <br>
                            </v-card-text>

                        </v-row>
                    </v-card-text>

                    <v-card-actions justify="center" class="text-center ma-4">
                        @if($plan->id == 3)
                        <v-btn x-large block color="primary" href="/register-customer">Select</v-btn>
                        @else
                        <v-btn x-large block outlined color="grey" class="text-black" href="/register-customer">Select</v-btn>
                        @endif
                    </v-card-actions>

                </v-card>
            </v-col>
            @endforeach
        </v-row>
        </v-card>


    </v-container>

    <!-- <v-container class="grey lighten-5">
            <v-row no-gutters style="height: 150px;">
                <v-col v-for="align in alignments" :key="align" :align-self="align">
                    <v-card class="pa-2" outlined tile>
                        One of three columns
                    </v-card>
                </v-col>
            </v-row>
        </v-container> -->
</div>
@endsection('content')
