<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Public Routes

Route::get('/', [App\Http\Controllers\FrontEndController::class, 'index'])->name('index');
Route::get('how-it-works', [App\Http\Controllers\FrontEndController::class, 'howItWorks'])->name('howItWorks');
Route::get('pricing/plans', [App\Http\Controllers\FrontEndController::class, 'pricingPlans'])->name('pricing.plans');
Route::get('book-online', [App\Http\Controllers\FrontEndController::class, 'bookOnline'])->name('bookOnline');
Route::get('contact', [App\Http\Controllers\FrontEndController::class, 'contact'])->name('contact');


// Customer Routes:
Route::middleware(['auth', 'subscription'])->group(function () {
    Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('coupons', [App\Http\Controllers\HomeController::class, 'coupons'])->name('coupons');
    Route::get('subscriptions', [App\Http\Controllers\HomeController::class, 'subscriptions'])->name('subscriptions');
    Route::get('settings', [App\Http\Controllers\HomeController::class, 'settings'])->name('settings');
});

Route::get('/qrcode/{tag}', [App\Http\Controllers\HomeController::class, 'qrcode'])->name('qrcode');
Route::get('/qrcode-download/{tag}', [App\Http\Controllers\HomeController::class, 'qrcodeDownload'])->name('qrcode.download');

// Live signup
Route::get('/live-signup/{liveurl}', [App\Http\Controllers\HomeController::class, 'liveSignup'])->name('live-signup');
Route::get('/signup-survey/{liveurl}', [App\Http\Controllers\HomeController::class, 'signupSurvey'])->name('signup-survey');

Route::post('/do-live-signup', [App\Http\Controllers\Auth\RegisterController::class, 'doLiveSignup'])->name('do-live-signup');
Route::get('/send-test', [App\Http\Controllers\Auth\RegisterController::class, 'sendTest'])->name('send-test');

Route::get('/pricing-plans', [App\Http\Controllers\HomeController::class, 'pricingPlans'])->name('pricing-plans');
Route::get('/terms/{liveurl}', [App\Http\Controllers\HomeController::class, 'terms'])->name('terms');

Route::get('/survey', function () {
    return view('survey');
});

Route::get('/user-agreement', function () {
    return view('agreement');
});

Route::get('/login', function () {
    return view('auth/login');
})->name('login');

Route::get('/register-customer', function () {
    return view('auth/registerCustomer');
})->name('register-customer');
Route::get('/login-customer', function () {
    return view('auth/loginCustomer');
})->name('login-customer');
Route::get('/create-survey', function () {
    return view('createSurvey');
})->name('create-survey');

Route::post('/register-new-customer', [App\Http\Controllers\Auth\RegisterController::class, 'registerNewCustomer'])->name('register-new-customer');
Route::get('/password-reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'resetPasswordPhone'])->name('password-reset');
Route::post('/send-reset-sms', [App\Http\Controllers\Auth\ResetPasswordController::class, 'sendResetSms'])->name('send-reset-sms');
Route::get('/reset/{token}', function () {
    return view('reset');
});
// Route::get('/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset']);
Route::post('/handle-reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'handleReset']);
Route::post('/send-test-sms', [App\Http\Controllers\HomeController::class, 'sendTestSms'])->name('send-test-sms');
Auth::routes();

// Routes

Route::get('/admin-tools', [App\Http\Controllers\HomeController::class, 'adminTools'])->name('admin-tools');
Route::get('/redeem/{coupon}', [App\Http\Controllers\HomeController::class, 'redeem'])->name('redeem');
Route::get('/pricing-plans', [App\Http\Controllers\PaymentController::class, 'pricingPlans'])->name('pricing-plans');
Route::get('/view-plan/{plan}', [App\Http\Controllers\PaymentController::class, 'viewPlan'])->name('view-plan');
Route::get('/purchase-plan', [App\Http\Controllers\PaymentController::class, 'purchasePlan'])->name('purchase-plan');
Route::post('/payment-create', [App\Http\Controllers\PaymentController::class, 'paymentCreate'])->name('payment-create');
Route::get('/view-customer-survey', [App\Http\Controllers\HomeController::class, 'viewCustomerSurvey'])->name('view-customer-survey');


// Actions
Route::post('/update-subs', [App\Http\Controllers\ActionController::class, 'updateSubs'])->name('update-subs');
Route::post('/create-coupon', [App\Http\Controllers\ActionController::class, 'createCoupon'])->name('create-coupon');
Route::post('/redeem-coupon', [App\Http\Controllers\ActionController::class, 'redeemCoupon'])->name('redeem-coupon');
Route::post('/update-settings', [App\Http\Controllers\ActionController::class, 'updateSettings'])->name('update-settings');
Route::post('/update-user-settings', [App\Http\Controllers\ActionController::class, 'updateUserSettings'])->name('update-user-settings');
Route::post('/update-sms', [App\Http\Controllers\ActionController::class, 'updateSms'])->name('update-sms');
Route::post('/update-static-coupons', [App\Http\Controllers\ActionController::class, 'updateStaticCoupons'])->name('update-static-coupons');
Route::post('/create-group', [App\Http\Controllers\ActionController::class, 'createGroup'])->name('create-group');
Route::get('/get-group/{id}', [App\Http\Controllers\ActionController::class, 'getGroup'])->name('get-group');
Route::get('/delete-group/{id}', [App\Http\Controllers\ActionController::class, 'deleteGroup'])->name('delete-group');

Route::post('/delete-group-v2', [App\Http\Controllers\ActionController::class, 'deleteGroupV2'])->name('delete-group-v2');


Route::post('/save-survey', [App\Http\Controllers\ActionController::class, 'saveSurvey'])->name('save-survey');
Route::post('/save-survey-response', [App\Http\Controllers\ActionController::class, 'saveSurveyResponse'])->name('save-survey-response');

// Phone verification
Route::get('phone/verify', [App\Http\Controllers\HomeController::class, 'show'])->name('phoneverification.show');
Route::post('phone/verify', [App\Http\Controllers\ActionController::class, 'verify'])->name('phoneverification.verify');
Route::get('phone/resend', [App\Http\Controllers\HomeController::class, 'resend'])->name('phoneverification.resend');
Route::post('phone/resend', [App\Http\Controllers\ActionController::class, 'resendSms'])->name('phoneverification.resend.sms');
Route::post('reset-password-sms', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'resetSms'])->name('reset-password-sms');
Route::post('reset/{token}', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'reset'])->name('reset');

Route::get('/forgot-password-sms', function () {
    return view('forgotsms');
})->name('forgot-password-sms');
