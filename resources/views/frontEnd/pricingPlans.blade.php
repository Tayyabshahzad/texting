@extends('layouts.main')
@section('title', 'Pricing Plans')
@section('page_style')
    <link rel="stylesheet" href="{{ asset('assets/css/pricingplans.css') }}" />
@endsection
@section('content')

<section>
    <div class="container-fluid td-page-title">
      <div class="row">
        <div class="col text-center">
          <h2>Pricing Plans</h2>
        </div>
      </div>
    </div>
  </section>
  <!-- pricing tables -->
  <section class="td-pricing-tables">
    <div class="container td-tables-container">
      <div class="row td-table-box">
        <div class="col">
          <ul
            class="nav nav-pills justify-content-center gap-4"
            id="pills-tab"
            role="tablist"
          >
            <li class="nav-item" role="presentation">
              <button
                class="nav-link active"
                id="pills-monthly-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-monthly"
                type="button"
                role="tab"
                aria-controls="pills-monthly"
                aria-selected="true"
              >
                Monthly
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button
                class="nav-link"
                id="pills-yearly-tab"
                data-bs-toggle="pill"
                data-bs-target="#pills-yearly"
                type="button"
                role="tab"
                aria-controls="pills-yearly"
                aria-selected="false"
              >
                Yearly
              </button>
            </li>
          </ul>
          <div class="tab-content mt-5" id="pills-tabContent">
            <div
              class="tab-pane fade show active"
              id="pills-monthly"
              role="tabpanel"
              aria-labelledby="pills-monthly-tab"
            >
              <div
                class="row d-md-flex gap-4 text-center justify-content-center"
              >
                <div class="td-table">
                  <h3 class="td-table-title">Starter Plan</h3>
                  <h2 class="td-table-price">
                    $50<span class="d-block">Monthly</span>
                  </h2>
                  <p class="td-table-desc">Up to 500 Messages Per Month</p>
                  <button class="td-table-btn">
                    <a href="#">Subscribe</a>
                  </button>
                </div>
                <div class="td-table position-relative">
                  <div
                    class="d-flex justify-content-center gap-3 pb-3 position-absolute td-btns-position"
                  >
                    <button class="text-white td-popular-btn">
                      Most popular
                    </button>
                    <button class="text-white td-best-btn">Best Value</button>
                  </div>
                  <h3 class="td-table-title text-white">Business Builder</h3>
                  <h2 class="td-table-price text-white">
                    $110<span class="d-block text-white">Monthly</span>
                  </h2>
                  <p class="td-table-desc text-white">
                    Up to 2500 Messages Per Month
                  </p>
                  <button class="td-table-btn text-white">
                    <a href="#">Subscribe</a>
                  </button>
                </div>
                <div class="td-table">
                  <h3 class="td-table-title">Pro Plan</h3>
                  <h2 class="td-table-price">
                    $200<span class="d-block">Monthly</span>
                  </h2>
                  <p class="td-table-desc">Up to 5000 Messages Per Month</p>
                  <button class="td-table-btn">
                    <a href="#">Subscribe</a>
                  </button>
                </div>
                <div class="td-table">
                  <h3 class="td-table-title">Elite Plan</h3>
                  <h2 class="td-table-price">
                    $400<span class="d-block">Monthly</span>
                  </h2>
                  <p class="td-table-desc">Up to 10000 Messages Per Month</p>
                  <button class="td-table-btn">
                    <a href="#">Subscribe</a>
                  </button>
                </div>
              </div>
            </div>
            <div
              class="tab-pane fade"
              id="pills-yearly"
              role="tabpanel"
              aria-labelledby="pills-yearly-tab"
            >
              <div
                class="row d-md-flex gap-4 text-center justify-content-center"
              >
                <div class="td-table">
                  <h3 class="td-table-title">Starter Plan</h3>
                  <h2 class="td-table-price">
                    $50<span class="d-block">Yearly</span>
                  </h2>
                  <p class="td-table-desc">Up to 500 Messages Per Month</p>
                  <button class="td-table-btn">
                    <a href="#">Subscribe</a>
                  </button>
                </div>
                <div class="td-table position-relative">
                  <div
                    class="d-flex justify-content-center gap-3 pb-3 position-absolute td-btns-position"
                  >
                    <button class="text-white td-popular-btn">
                      Most popular
                    </button>
                    <button class="text-white td-best-btn">Best Value</button>
                  </div>
                  <h3 class="td-table-title text-white">Business Builder</h3>
                  <h2 class="td-table-price text-white">
                    $110<span class="d-block text-white">Yearly</span>
                  </h2>
                  <p class="td-table-desc text-white">
                    Up to 2500 Messages Per Month
                  </p>
                  <button class="td-table-btn text-white">
                    <a href="#">Subscribe</a>
                  </button>
                </div>
                <div class="td-table">
                  <h3 class="td-table-title">Pro Plan</h3>
                  <h2 class="td-table-price">
                    $200<span class="d-block">Yearly</span>
                  </h2>
                  <p class="td-table-desc">Up to 5000 Messages Per Month</p>
                  <button class="td-table-btn">
                    <a href="#">Subscribe</a>
                  </button>
                </div>
                <div class="td-table">
                  <h3 class="td-table-title">Elite Plan</h3>
                  <h2 class="td-table-price">
                    $400<span class="d-block">Yearly</span>
                  </h2>
                  <p class="td-table-desc">Up to 10000 Messages Per Month</p>
                  <button class="td-table-btn">
                    <a href="#">Subscribe</a>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection
