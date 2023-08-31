@extends('layouts.master')
@section('content')
    <div class="row td-coupons">
        <div class="col-md-12 px-5 text-center py-3 d-md-flex align-items-center justify-content-between">
            <h2 class="td-dashboard-title">Coupons</h2>
            <button class="td-addCoupon-btn">+ Add New Coupon</button>
        </div>
        <div class="col-md-12">
            <ul class="nav nav-pills mb-3 td-coupons-tabs" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all"
                        type="button" role="tab" aria-controls="pills-all" aria-selected="true">
                        All
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-expired-tab" data-bs-toggle="pill" data-bs-target="#pills-expired"
                        type="button" role="tab" aria-controls="pills-expired" aria-selected="false">
                        Expired
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-redeemed-tab" data-bs-toggle="pill" data-bs-target="#pills-redeemed"
                        type="button" role="tab" aria-controls="pills-redeemed" aria-selected="false">
                        Redeemed
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
                    <div class="row justify-content-between px-md-5 px-2 pt-5">

                        @foreach ($coupons as $coupon )
                            <div class="col-md-4 col-12 td-coupon-card">
                                <div class="circle-1"></div>
                                <div class="circle-2"></div>
                                <div class="d-flex justify-content-between align-item-center">
                                    <h2>Code: {{ $coupon->code }}</h2>
                                    <div>
                                        <button class="td-eye">
                                            <img src="./assets/images/eye.png" alt="eye" />
                                        </button>
                                        <button class="td-del">
                                            <img src="./assets/images/delete.png" alt="bin" />
                                        </button>
                                    </div>
                                </div>
                                <ul class="list-unstyled">
                                    <li>Coupon ID: <span> {{ $coupon->id }} </span></li>
                                    <li>Coupon Created: <span>  {{ $coupon->created_at }} </span></li>
                                    <li>Coupon Expires: <span> {{ $coupon->expiry }} </span></li>
                                    <li> <small> {{ route('redeem',$coupon->id) }}  </small> </li>
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-expired" role="tabpanel" aria-labelledby="pills-expired-tab">
                    <div class="row justify-content-between px-md-5 px-2 pt-5">
                        @foreach ($coupons_expires as $coupon )
                            <div class="col-md-4 col-12 td-coupon-card">
                                <div class="circle-1"></div>
                                <div class="circle-2"></div>
                                <div class="d-flex justify-content-between align-item-center">
                                    <h2>Code: {{ $coupon->code }}</h2>
                                    <div>
                                        <button class="td-eye">
                                            <img src="./assets/images/eye.png" alt="eye" />
                                        </button>
                                        <button class="td-del">
                                            <img src="./assets/images/delete.png" alt="bin" />
                                        </button>
                                    </div>
                                </div>
                                <ul class="list-unstyled">
                                    <li>Coupon ID: <span> {{ $coupon->id }} </span></li>
                                    <li>Coupon Created: <span>  {{ $coupon->created_at }} </span></li>
                                    <li>Coupon Expires: <span> {{ $coupon->expiry }} </span></li>
                                    <li> <small> {{ route('redeem',$coupon->id) }}  </small> </li>
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-redeemed" role="tabpanel" aria-labelledby="pills-redeemed-tab">
                    <div class="row justify-content-between px-md-5 px-2 pt-5">
                        @foreach ($coupons as $coupon )
                            <div class="col-md-4 col-12 td-coupon-card">
                                <div class="circle-1"></div>
                                <div class="circle-2"></div>
                                <div class="d-flex justify-content-between align-item-center">
                                    <h2>Code: {{ $coupon->code }}</h2>
                                    <div>
                                        <button class="td-eye">
                                            <img src="./assets/images/eye.png" alt="eye" />
                                        </button>
                                        <button class="td-del">
                                            <img src="./assets/images/delete.png" alt="bin" />
                                        </button>
                                    </div>
                                </div>
                                <ul class="list-unstyled">
                                    <li>Coupon ID: <span> {{ $coupon->id }} </span></li>
                                    <li>Coupon Created: <span>  {{ $coupon->created_at }} </span></li>
                                    <li>Coupon Expires: <span> {{ $coupon->expiry }} </span></li>
                                    <li> <small> {{ route('redeem',$coupon->id) }}  </small> </li>
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_js')
@endsection
