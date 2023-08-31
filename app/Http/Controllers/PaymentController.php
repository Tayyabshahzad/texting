<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Stripe;
use Session;
use Exception;
use App\Models\PricingPlan;

class PaymentController extends Controller
{

    public function paymentCreate(Request $request)
    {

        $user = auth()->user();
        $input = $request->all();
        $token =  $request->stripeToken;
        $pricingPlan = PricingPlan::find($request->plan);
        $paymentMethod = $request->paymentMethod;

        try {

            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            if (is_null($user->stripe_id)) {

                $stripeCustomer = $user->createAsStripeCustomer();
            }

            \Stripe\Customer::createSource(
                $user->stripe_id,
                ['source' => $token]
            );

            if ($user && !$user->stripeSubscription) {
                $user->newSubscription($pricingPlan->stripe_plan, $pricingPlan->stripe_price)
                    ->create($paymentMethod, [
                        'email' => $user->email,
                    ]);
            } else {
                return back()->with('error', "Subscription Exists");
            }

            return back()->with('success', 'Subscription is completed.');
        } catch (Exception $e) {
            dd($e);
            return back()->with('error', $e->getMessage());
        }
        // $plan = PricingPlan::find(2);
    }

    // This generates the view, the second function generates view links and payments
    public function pricingPlans()
    {
        $plans = PricingPlan::all();
        return view('pricing', ['plans' => $plans]);
    }

    public function viewPlan($plan)
    {
        if (auth()->user() && auth()->user()->stripeSubscription) {
            return redirect()->route('login');
        } else {
            $plan = PricingPlan::find($plan);

            $stripe = new \Stripe\StripeClient(
                env('STRIPE_SECRET')
            );

            // $intent = auth()->user()->createSetupIntent();

            // // return view('payment.create', [
            // //     'intent' => $intent,
            // //     'plan' => $plan
            // // ]);

            return view('viewplan', ['plan' => $plan]);
        }
    }

    public function purchasePlan()
    {
        // $intent = auth()->user()->createSetupIntent();
        $plans = PricingPlan::all();
        return view('purchaseplan', ['plans' => $plans]);
    }
}
