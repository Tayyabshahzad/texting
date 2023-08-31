<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Models\PasswordResetSms;
use App\Models\User;
use Exception;
use Twilio\Rest\Client;


class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function resetSms(Request $request)
    {
        // $request->validate([
        //     'phone' => 'required|max:10'
        // ]);

        $sec1  = mt_rand(1000, 9000);
        $sec2  = mt_rand(1000, 9000);
        $sec3  = mt_rand(1000, 9000);

        $tokenVal = $sec1 . '-' . $sec2 . '-' . $sec3;

        $reset = new PasswordResetSms();
        $reset->phone = $request->phone;
        $reset->token = $tokenVal;
        $reset->complete = false;
        $reset->save();

        $passwordUrl = 'https://dashboard.textingdiscounts.com/reset/' . $tokenVal;

        // Your Account SID and Auth Token from twilio.com/console
        $account_sid = env("TWILIO_SID");
        $auth_token = env("TWILIO_TOKEN");
        $twilio_number = env("TWILIO_FROM");
        $client = new Client($account_sid, $auth_token);

        if ($request->phone == '27713400456') {
            $phone = '+' . $request->phone;
        } else {
            $phone = '+1' . $request->phone;
        }

        $bodyTxt = "Reset your password: " . $passwordUrl;

        // Send SMS
        try {
            $apiResponse = $client->messages->create(
                $phone, // to
                [
                    "body" => $bodyTxt,
                    "from" => $twilio_number
                ]
            );
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['data']['error_message'] = $result['message'];

            return response()->json(['message' => $result['message']]);
        }

        return response()->json(['message' => 'Success']);
    }
}
