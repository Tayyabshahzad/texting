@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
                <!-- <div class="card-header">
                    @hasrole('User')
                    User
                    @endhasrole

                    @hasrole('Super-Admin')
                    SU
                    @endhasrole

                    @hasrole('Customer')
                    Customer
                    @endhasrole

                    {{ __('Dashboard') }}
                </div> -->

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    @hasrole('Customer')
                    <div>
                        <customer-dashboard :groups="{{ $groups }}" :user="{{ Auth::user() }}" :coupons="{{ Auth::user()->customerCoupons->where('type', 1) }}" :subscribers="{{ $subscribers }}" :details="{{ $customerdetails }}" :subscriber-stats='@json($subscriberstats)' :coupon-stats="{{ $couponstats }}" :redeemed-ratio='@json($redeemedratio)' :saved-newuser-coupon="{{ $savedNewuserCoupon }}" :saved-birthday-coupon="{{ $savedBirthdayCoupon }}" :sent-total="{{ $sentTotal }}" :current-plan="{{ $currentPlan }}" :total-subscribers="{{ $totalSubscribers }}" :monthly-subscribers="{{ $monthlySubscribers }}" :url='@json($liveurl)' :survey='@json($survey)' :survey-counts="{{ $surveyCounts }}">
                        </customer-dashboard>
                    </div>
                    @endhasrole

                    @hasrole('User')
                    <div>
                        <user-dashboard :user="{{ Auth::user() }}" :available="{{ $available }}" :subscriptions="{{ Auth::user()->userSubscriptions->where('unsubbed_at', NULL)->pluck('customer_details_id') }}" :coupon-list="{{ $couponList }}">
                        </user-dashboard>
                    </div>
                    @endhasrole
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
