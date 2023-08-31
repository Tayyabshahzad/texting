@extends('layouts.main')
@section('title', 'How It Works')
@section('page_style')
    <link rel="stylesheet" href="{{ asset('assets/css/howItWorks.css') }}" />
@endsection
@section('content')
<section>
    <div class="container-fluid td-how-it-works position-relative">
      <div class="row">
        <div class="col td-works-content-box position-absolute">
          <h2 class="text-white">Simple, Clean, and Easy</h2>
          <p class="text-white">
            You and your staff are busy. You need a simple solution to help
            drive customers to your door and keep them coming back. We have a
            simple process to help you get the most out of our service and
            provide your customers with the value they deserve.
          </p>
        </div>
      </div>
    </div>
  </section>
  <!-- page title -->
  <section>
    <div class="container td-title-container">
      <div class="row">
        <div class="col">
          <h2 class="text-center">How It Works</h2>
        </div>
      </div>
    </div>
  </section>
  <!-- steps section -->
  <section>
    <div class="container td-steps-container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <div class="td-step-box">
            <h3 class="td-step-numb">Step 1:</h3>
            <h2 class="td-step-title">Gather Data</h2>
            <p class="td-step desc">
              Using our custom and complimentary signage, emails, and social
              media posts, you will have hundreds of costumers signing up to
              receive communication from you via text message.
            </p>
          </div>
        </div>
        <div class="col-lg-6 text-lg-end text-center">
          <img
            class="img-fluid"
            src="/assets/images/step-1.png"
            alt="Step one"
          />
        </div>
      </div>
      <div class="row align-items-center flex-lg-row flex-column-reverse">
        <div class="col-lg-6 text-lg-start text-center">
          <img
            class="img-fluid"
            src="/assets/images/step-2.png"
            alt="Step two"
          />
        </div>
        <div class="col-lg-6">
          <div class="td-step-box">
            <h3 class="td-step-numb">Step 2:</h3>
            <h2 class="td-step-title">Schedule Promotions</h2>
            <p class="td-step desc">
              Schedule your promotions. Follow our best practices guide for
              highest converting results.
            </p>
          </div>
        </div>
      </div>
      <div class="row align-items-center">
        <div class="col-lg-6">
          <div class="td-step-box">
            <h3 class="td-step-numb">Step 3:</h3>
            <h2 class="td-step-title">Redeem Coupons</h2>
            <p class="td-step desc">
              Once your customer has received the message, they simply come
              in, show their phone to your staff who seamlessly redeems the
              coupon with a code. The coupon then disappears from your
              customers profile making it so it cannot be redeemed again.
            </p>
          </div>
        </div>
        <div class="col-lg-6 text-lg-end text-center">
          <img
            class="img-fluid"
            src="/assets/images/step-3.png"
            alt="Step three"
          />
        </div>
      </div>
      <div class="row align-items-center flex-lg-row flex-column-reverse">
        <div class="col-lg-6 text-lg-start text-center">
          <img
            class="img-fluid"
            src="/assets/images/step-4.png"
            alt="Step four"
          />
        </div>
        <div class="col-lg-6">
          <div class="td-step-box">
            <h3 class="td-step-numb">Step 4:</h3>
            <h2 class="td-step-title">Gather Data</h2>
            <p class="td-step desc">
              Once your customer has received the message, they simply come
              in, show their phone to your staff who seamlessly redeems the
              coupon with a code. The coupon then disappears from your
              customers profile making it so it cannot be redeemed again.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection
