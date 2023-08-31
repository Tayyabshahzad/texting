@extends('layouts.main')
@section('title', 'Home Page')
@section('page_style')
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}" />
@endsection

@section('content')
    <!-- hero section -->
    <section>
        <div class="container-fluid td-hero-section">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h1 class="text-light">
                            Easy To Use, Direct to Consumer Text Message Coupons to be
                            redeemed in store.
                        </h1>
                        <button class="td-heroSection-btn">Learn More</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- our proven process -->
    <section>
        <div class="container-fluid td-process-section">
            <div class="container">
                <div class="row g-0">
                    <div class="col">
                        <h2 class="text-center td-process-title">Our Proven Process</h2>
                        <p class="text-center td-process-desc pb-5">
                            Our process has been a work in progress for years. We are
                            excited to be able to share our system with the public!
                        </p>
                    </div>
                    <div class="row g-0">
                        <div class="col-xl-4 col-lg-6 td-process-cards">
                            <div class="td-card-image text-center">
                                <img class="img-fluid" src="./assets/images/promotion.png" alt="promotion" />
                            </div>
                            <h2 class="text-center">Create a promotion</h2>
                            <p class="text-center">
                                Create meaningful promotions for your guests. From BOGO's to
                                Gift Cards and everything in-between.
                            </p>
                        </div>
                        <div class="col-xl-4 col-lg-6 td-process-cards">
                            <div class="td-card-image text-center">
                                <img class="img-fluid" src="./assets/images/customer.png" alt="customer" />
                            </div>
                            <h2 class="text-center">Send to your customers</h2>
                            <p class="text-center">
                                As often as you'd like, send messages to your customers. Our
                                complimentary best practices guide has all the information you
                                need to get the best conversion from your messages.
                            </p>
                        </div>
                        <div class="col-xl-4 col-lg-6 td-process-cards">
                            <div class="td-card-image text-center">
                                <img class="img-fluid" src="./assets/images/redeem.png" alt="redeem" />
                            </div>
                            <h2 class="text-center">Easily redeem in person</h2>
                            <p class="text-center">
                                Sick of having coupons that get used multiple times by the
                                same guest? Sick of having difficult to use platforms for your
                                staff to implement. Not anymore. Our easy to use system keeps
                                your guests and your customers happy!
                            </p>
                        </div>
                        <div class="col-12 text-center mt-5">
                            <button class="td-processSection-btn">Sign Up</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- CTA -->
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 td-cta-leftCOlumn">
                    <div class="cta-content-box text-center text-md-start">
                        <h2 class="text-white">
                            15 Minutes<br />
                            Free Consultation
                        </h2>
                        <button class="td-video-btn d-initial d-md-block">
                            <img src="./assets/images/video-camera.png" alt="video-camera-icon" />Available Online
                        </button>
                        <button class="td-ctaSection-btn">Learn More</button>
                    </div>
                </div>
                <div class="col-lg-6 p-0">
                    <img class="img-fluid cta-bg-banner" src="./assets/images/cta-banner.png" alt="CTA bg-banner" />
                </div>
            </div>
        </div>
    </section>
    <!-- unique features -->
    <section>
        <div class="container-fluid td-features-container">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <h2 class="td-features-title text-md-initial text-center">
                            Unique Features
                        </h2>
                        <p class="td-features-description text-md-initial text-center">
                            Included in every project
                        </p>
                        <div class="text-center">
                            <img class="img-fluid" src="./assets/images/features-image.png" alt="feature-section-image" />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="td-features-boxex">
                            <div class="d-md-flex d-block td-features-box">
                                <div>
                                    <img src="./assets/images/list-icon.png" alt="list-icon" />
                                </div>
                                <div>
                                    <h2>Currated Lists</h2>
                                    <p>
                                        Stop sending messages to all of your subscribers and send
                                        them only to your most frequent users! Save money and fine
                                        tune your marketing efforts!
                                    </p>
                                </div>
                            </div>
                            <div class="d-md-flex d-block td-features-box">
                                <div>
                                    <img src="./assets/images/dashboard-icon.png" alt="dashboard-icon" />
                                </div>
                                <div>
                                    <h2>Full Data Dashboard</h2>
                                    <p>
                                        Data drives marketing! Utilize your dashboard to make the
                                        best decisions to drive people to your business.
                                    </p>
                                </div>
                            </div>
                            <div class="d-md-flex d-block td-features-box">
                                <div>
                                    <img src="./assets/images/like-icon.png" alt="like-icon" />
                                </div>
                                <div>
                                    <h2>Industry Best Practices</h2>
                                    <p>
                                        Whether you are in the coffee, restuarant, or brewery
                                        business, we have industry experts to help you put
                                        together the best promotions to drive traffic and increase
                                        revenue!
                                    </p>
                                </div>
                            </div>
                            <div>
                                <button class="td-featureSection-btn">Sign Up</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- testimonial -->
    <section>
        <div class="container-fluid td-testmonials">
            <div class="row">
                <div class="col">
                    <h2 class="text-center td-testmonials-title">Testimonials</h2>
                    <div class="responsive">
                        <div class="td-testimonial-box">
                            <p class="text-center pb-5">
                                "We started using Texting Discounts a few months ago and have
                                been thrilled with the results. Our customers eagerly sign up
                                for our VIP Text Club, and the platform makes it easy to
                                schedule and send out special offers and promotions. Since
                                implementing this service, we've seen a significant increase
                                in repeat business and customer loyalty. The reporting
                                features have also been invaluable in tracking the success of
                                our campaigns and adjusting our marketing efforts accordingly.
                                I can't imagine running our coffee shop without Texting
                                Discounts now. It's been a game-changer!"
                            </p>
                            <div class="d-flex td-client-review">
                                <div class="td-client-name position-relative text-center">
                                    <span>J</span>
                                </div>
                                <div>
                                    <h3>Jake M, Anoka MN</h3>
                                </div>
                            </div>
                        </div>
                        <div class="td-testimonial-box">
                            <p class="text-center pb-5">
                                "We started using Texting Discounts a few months ago and have
                                been thrilled with the results. Our customers eagerly sign up
                                for our VIP Text Club, and the platform makes it easy to
                                schedule and send out special offers and promotions. Since
                                implementing this service, we've seen a significant increase
                                in repeat business and customer loyalty. The reporting
                                features have also been invaluable in tracking the success of
                                our campaigns and adjusting our marketing efforts accordingly.
                                I can't imagine running our coffee shop without Texting
                                Discounts now. It's been a game-changer!"
                            </p>
                            <div class="d-flex td-client-review">
                                <div class="td-client-name position-relative text-center">
                                    <span>S</span>
                                </div>
                                <div>
                                    <h3>Sara V, Eau Claire WI</h3>
                                </div>
                            </div>
                        </div>
                        <div class="td-testimonial-box">
                            <p class="text-center pb-5">
                                "We started using Texting Discounts a few months ago and have
                                been thrilled with the results. Our customers eagerly sign up
                                for our VIP Text Club, and the platform makes it easy to
                                schedule and send out special offers and promotions. Since
                                implementing this service, we've seen a significant increase
                                in repeat business and customer loyalty. The reporting
                                features have also been invaluable in tracking the success of
                                our campaigns and adjusting our marketing efforts accordingly.
                                I can't imagine running our coffee shop without Texting
                                Discounts now. It's been a game-changer!"
                            </p>
                            <div class="d-flex td-client-review">
                                <div class="td-client-name position-relative text-center">
                                    <span>A</span>
                                </div>
                                <div>
                                    <h3>Andy R, Fridley MN</h3>
                                </div>
                            </div>
                        </div>
                        <div class="td-testimonial-box">
                            <p class="text-center pb-5">
                                "We started using Texting Discounts a few months ago and have
                                been thrilled with the results. Our customers eagerly sign up
                                for our VIP Text Club, and the platform makes it easy to
                                schedule and send out special offers and promotions. Since
                                implementing this service, we've seen a significant increase
                                in repeat business and customer loyalty. The reporting
                                features have also been invaluable in tracking the success of
                                our campaigns and adjusting our marketing efforts accordingly.
                                I can't imagine running our coffee shop without Texting
                                Discounts now. It's been a game-changer!"
                            </p>
                            <div class="d-flex td-client-review">
                                <div class="td-client-name position-relative text-center">
                                    <span>J</span>
                                </div>
                                <div>
                                    <h3>Jake M, Anoka MN</h3>
                                </div>
                            </div>
                        </div>
                        <div class="td-testimonial-box">
                            <p class="text-center pb-5">
                                "We started using Texting Discounts a few months ago and have
                                been thrilled with the results. Our customers eagerly sign up
                                for our VIP Text Club, and the platform makes it easy to
                                schedule and send out special offers and promotions. Since
                                implementing this service, we've seen a significant increase
                                in repeat business and customer loyalty. The reporting
                                features have also been invaluable in tracking the success of
                                our campaigns and adjusting our marketing efforts accordingly.
                                I can't imagine running our coffee shop without Texting
                                Discounts now. It's been a game-changer!"
                            </p>
                            <div class="d-flex td-client-review">
                                <div class="td-client-name position-relative text-center">
                                    <span>J</span>
                                </div>
                                <div>
                                    <h3>Jake M, Anoka MN</h3>
                                </div>
                            </div>
                        </div>
                        <div class="td-testimonial-box">
                            <p class="text-center pb-5">
                                "We started using Texting Discounts a few months ago and have
                                been thrilled with the results. Our customers eagerly sign up
                                for our VIP Text Club, and the platform makes it easy to
                                schedule and send out special offers and promotions. Since
                                implementing this service, we've seen a significant increase
                                in repeat business and customer loyalty. The reporting
                                features have also been invaluable in tracking the success of
                                our campaigns and adjusting our marketing efforts accordingly.
                                I can't imagine running our coffee shop without Texting
                                Discounts now. It's been a game-changer!"
                            </p>
                            <div class="d-flex td-client-review">
                                <div class="td-client-name position-relative text-center">
                                    <span>J</span>
                                </div>
                                <div>
                                    <h3>Jake M, Anoka MN</h3>
                                </div>
                            </div>
                        </div>
                        <div class="td-testimonial-box">
                            <p class="text-center pb-5">
                                "We started using Texting Discounts a few months ago and have
                                been thrilled with the results. Our customers eagerly sign up
                                for our VIP Text Club, and the platform makes it easy to
                                schedule and send out special offers and promotions. Since
                                implementing this service, we've seen a significant increase
                                in repeat business and customer loyalty. The reporting
                                features have also been invaluable in tracking the success of
                                our campaigns and adjusting our marketing efforts accordingly.
                                I can't imagine running our coffee shop without Texting
                                Discounts now. It's been a game-changer!"
                            </p>
                            <div class="d-flex td-client-review">
                                <div class="td-client-name position-relative text-center">
                                    <span>J</span>
                                </div>
                                <div>
                                    <h3>Jake M, Anoka MN</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- contact us -->
    <section>
        <div class="container-fluid td-contact">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 td-contact-us text-lg-start text-center">
                        <h2 class="td-contact-title m-lg-0 m-auto">
                            We would love to hear from you!
                        </h2>
                        <img src="./assets/images/email.png" alt="email-icon" />
                        <h4>Email us at:</h4>
                        <h3>info@textingdiscounts.com</h3>
                    </div>
                    <div class="col-lg-6 td-contact-form">
                        <form class="text-md-start text-center">
                            <h2 class="td-form-title pb-3">Contact Us</h2>
                            <div class="d-md-flex gap-3 d-block">
                                <input type="text" placeholder="Enter your name" />
                                <input type="text" placeholder="Enter your email" />
                            </div>
                            <div class="d-md-flex gap-3 d-block">
                                <input type="text" placeholder="Enter your phone number" />
                                <input type="text" placeholder="Enter your address" />
                            </div>
                            <input type="text" placeholder="Subject" />
                            <textarea placeholder="Message"></textarea>
                            <button class="td-submit-btn" type="submit ">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- footer -->
@endsection
