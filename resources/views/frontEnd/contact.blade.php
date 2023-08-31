@extends('layouts.main')
@section('title', 'Contact Us')
@section('page_style')
    <link rel="stylesheet" href="{{ asset('assets/css/contact.css') }}" />
@endsection
@section('content')

<section>
    <div class="container-fluid td-page-title">
      <div class="row">
        <div class="col text-center">
          <h2>Contact Us</h2>
        </div>
      </div>
    </div>
  </section>
  <!-- contact section -->
  <section class="td-contact-section">
    <div class="container td-contactus-container">
      <div class="row td-content-box">
        <div class="col-lg-6 td-contact-form">
          <form class="text-md-start text-center">
            <div class="d-md-flex gap-3 d-block">
              <input type="text" placeholder="Enter your name" />
              <input type="text" placeholder="Enter your email" />
            </div>
            <div class="d-md-flex gap-3 d-block">
              <input type="text" placeholder="Enter your phone number" />
              <input type="text" placeholder="Enter your address" />
            </div>
            <input type="text" placeholder="Subject" />
            <textarea rows="5" placeholder="Message"></textarea>
            <button class="td-submit-btn" type="submit ">Submit</button>
          </form>
        </div>
        <div class="col-lg-6 text-center">
          <img
            class="img-fluid"
            src="./assets/images/contactus-img.png"
            alt=""
          />
        </div>
      </div>
    </div>
  </section>


@endsection
