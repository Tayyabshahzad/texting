@extends('layouts.app')

@section('content')
<redeem :user="{{ Auth::user() }} " :coupon="{{ $coupon }}" :place="{{ $place }}" :redeemed="{{ $redeemed }}"></redeem>
@endsection
